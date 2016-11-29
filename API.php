<?php
//api
error_reporting(E_ALL);
$possible_url = array("get_info", "put_iptables");
$return = "404";
if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
   if ($_GET["action"] == "get_info")
      $return = get_info();
      else if ($_GET["action"] == "put_iptables")
           $return = put_iptables();
}
exit(json_encode($return));

//fonction api
function get_info(){
         $dir = scan_dir();
         $re = '#-A PREROUTING.+?\\\\n#';
         $file = json_encode(file_get_contents("/etc/iptables/" . $dir[0]));
         preg_match_all("/-A PREROUTING.+?\\\\n/", $file, $output_array);
         $jsonfinal = array();
         foreach ($output_array[0] as $val){
                 preg_match_all("/[0-9]{0,3}\.[0-9]{0,3}\.[0-9]{0,3}\.[0-9]{0,3}                                                                                                                                                             /", $val, $ip);
                                                                                                                                                                                                                                                preg_match_all("/:([0-9-]+)/", $val, $port_int);
                                                                                                                                                                                                                                                                                preg_match_all("/--dport ([0-9:]+)/", $val, $                                                                                                                                                             port_ext);
                                                                                                                                                                                                                                                                         $json["ip"] = $ip[0][0];
                                                                                                                                                                                                                                                             $json["port_int"] = $port_int[1][0];
                                                                                                                                                                                                                                              $json["port_ext"] = $port_ext[1][0];
                                                                                                                                                                                                                                                                 array_push($jsonfinal,$json);
                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                return $jsonfinal;
}
function scan_dir(){
         $array = array();
         $dossier = scandir("/etc/iptables", 1);
         foreach ($dossier as $i){
                 if (strstr($i, "rules.v") AND !strstr($i, "~")){
                                array_push($array,$i);
                                        }
                                        }
                                        return ($array);
}

function put_iptables(){
         if (isset($_GET["ip"]) AND isset($_GET["port_int"]) AND isset($_GET["po                                                                                                                                                             rt_ext"])){
            // pas les droit d'ecriture ....
               // "sudo iptables -A PREROUTING -t nat -i tun0 -p tcp -m tcp --dp                                                                                                                                                             ort " . $_GET["port_ext"] . " -j DNAT --to-destination " . $_GET["ip"] . ":" . $                                                                                                                                                             _GET["port_int"]
                  echo shell_exec("sudo -u root -S iptables -A PREROUTING -t nat                                                                                                                                                              -i tun0 -p tcp -m tcp --dport ".$_GET["port_ext"]."  -j DNAT --to-destination "                                                                                                                                                             .$_GET["ip"].":".$_GET["port_int"]." < /home/mind7/pass;");
                  }
                  else
                  return "Bad parammeters, use ?action=put_iptables&ip=[IP]&port                                                                                                                                                             _int=[local port]&port_ext=[Gateway port]";
}
