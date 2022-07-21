cfg = {}
cfg.ssid = "Sourcetoad"
cfg.pwd = "!toadnet@2000!"
cfg.save = false
cfg.apiUrl = 'http://tasmota-220.sourcetoadtest.com'

STATE_START = 0
STATE_AWAITWIFI = 1
STATE_CONNECTED = 2

STATE_IDLE = 10
STATE_LAMP_ON = 11
STATE_LAMP_OFF = 12

STATE_ERROR = 999



local state = STATE_START
local counter = 0
local lamp_on = false
function state_machine()
    print('State: ' .. state)
    if state == STATE_START then
        wifi.setmode(wifi.STATION)
        wifi.sta.config(cfg)
        wifi.sta.connect()
        
        gpio.mode(3, gpio.OUTPUT)
        gpio.mode(7, gpio.INPUT, gpio.PULLUP)
        
        state = STATE_AWAITWIFI
    elseif state == STATE_AWAITWIFI then
        if wifi.sta.getip() == nil then
            print("Awaiting IP Address")
            state = STATE_AWAITWIFI
        else
            print("IP Address: " .. wifi.sta.getip())
            state = STATE_CONNECTED
        end
    elseif state == STATE_CONNECTED then
        state = STATE_IDLE
    elseif state == STATE_IDLE then
        local input = gpio.read(7)
        gpio.write(3, input)
        
        -- The switch is closed
        if input == gpio.LOW then
            counter = counter + 1
            print("Counter: " .. counter)
            if (counter > 3) and (not lamp_on) then
                lamp_on = true
                print('Turn on lamp')
                state = STATE_LAMP_ON
            end
        else
            if counter > 0 then
                lamp_on = false
                print('Turn off lamp')
                state = STATE_LAMP_OFF
            end
            counter = 0
        end
    elseif state == STATE_LAMP_ON then
        state = STATE_IDLE
        
        sock = net.createConnection()
        sock:connect(80, cfg.apiUrl)
        sock:on('connection', function (sck, s)
            sock:send('GET /api?status="open" HTTP/1.0\r\n\r\n')
        end)
        sock:on('sent', function (sck, s)
            print('Sent!')
            sck:close()
        end)
    elseif state == STATE_LAMP_OFF then
        state = STATE_IDLE
        
        sock = net.createConnection()
        sock:connect(80, cfg.apiUrl)
        sock:on('connection', function (sck, s)
            sock:send('GET /api?status="closed" HTTP/1.0\r\n\r\n')
        end)
        sock:on('sent', function (sck, s)
            print('Sent!')
            sck:close()
        end)
    end
    
    return STATE_ERROR
end


local loop = tmr.create()
loop:alarm(500, tmr.ALARM_AUTO, function ()
    state_machine()
end)
