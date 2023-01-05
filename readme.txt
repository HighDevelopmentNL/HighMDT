Add 4 new row in your players database structure:
web_pass VARCHAR(55)
username VARCHAR(55)
last_login VARCHAR(80)
lastsearch INT(10)


Add a new command in your pepe-police or ie replace players for characters_metadata if your using pepe:

QBCore.Commands.Add("zetmeos", "Bepaal Meos gebruikersnaam en wachtwoord", {{name="Gebruikersnaam", help="Enter a valid username"},{name="Password", help="Enter a valid password"}}, true, function(source, args)
    local Player = QBCore.Functions.GetPlayer(source)
    if args ~= nil then
        if Player.PlayerData.job.name == 'police' then
            if args[1] and args[2] ~= nil then
                QBCore.Functions.ExecuteSql(false, "UPDATE `characters_metadata` SET `web_pass` = @web_pass, `username` = @web_username WHERE `citizenid` = @citizenid", {
                    ["@web_username"] = args[1],
                    ["@web_pass"] = args[2],
                    ["@citizenid"] = Player.PlayerData.citizenid,
                })
                TriggerClientEvent('QBCore:Notify', source, '[MDT] Saved username and password', 'success')
            else
                TriggerClientEvent('QBCore:Notify', source, '[MDT] Please enter a valid username and password', 'success')
            end
        else
            TriggerClientEvent('QBCore:Notify', source, 'This is for police personel', 'error')
        end
    end
end)