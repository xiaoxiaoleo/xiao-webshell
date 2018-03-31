sub get_terminal_port()
terminal_port_path="HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Terminal Server\WinStations\RDP-Tcp\"
terminal_port_key="PortNumber"
termport=wsh.regread(terminal_port_path&terminal_port_key)
if termport="" or err.number<>0 then
response.write "无法得到终端服务端口。请检查权限是否已经受到限制。<br>"
else
response.write "当前终端服务端口: "&termport&"<br>"
end if
end sub