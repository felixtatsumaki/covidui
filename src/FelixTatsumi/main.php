
<?php

namespace FelixTatsumaki;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

use pocketmine\utils\Config;
use coba\forms_by_jojoe\FormAPI;
use coba\forms_by_jojoe\SimpleForm;
use coba\forms_by_jojoe\CustomForm;

use pocketmine\utils\TextFormat;
use pocketmine\entity\Attribute;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerInteractEvent;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getLogger()->info(C::GREEN . "[Enabled] PL BOOM");
    }

    public function onLoad(){
        $this->getLogger()->info(C::YELLOW . "[Loading] Plugin Sedang Loading");
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED . "[Disable] Plugin Terdapat Error / Butuh FormAPI");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "covidmenu":
                if($sender instanceof Player){
                    $this->PilihForm($sender);
                }else{
                    $sender->sendMessage("§cGunakan Command Dalam Game!");
                } 
                break;
        }
        return true;
    }

    public function PilihForm($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
		    case 0:
			  $this->Heal($sender);
              break;
            case 1:
              $this->CovidUI($sender);
              break;
            case 2:
              $this->Sn($sender);
              break;
            case 3:
              $nama = $sender->getName();
              $sender->getServer()->dispatchCommand($sender, "kill $nama");
              break;
            case 4:
               $nama = $sender->getName();
               $sender->getServer()->dispatchCommand($sender,"corona");
               break;
            case 5:
              $sender->sendMessage("§aComing Soon");
              $sender->addTitle("§eComing", "§fSoon");
              break;
            case 7:
              $sender->addTitle("Nakal", "Wkwk");
              break;
            case 8:
              $sender->addTitle("Masih","§4Dikerjakan");
                
           }
          });
          $form->setTitle("->CovidUI<-");
          $form->setContent("§l§b➛ §dHai §f" . $sender->getName() . "\n §aWelcome to Covid Menu⛏");
          $form->addButton("×§l§bHilangin Corona\n§aTap to Open");
          $form->addButton("×§l§bJadi Tuhan\n§aTap to Open");
          $form->addButton("×§l§bSantetUI\n§aTap to Open");
          $form->addButton("×§l§bBunuh Diri\n§aTap to Open");
          $form->addButton("×§l§bLihat Daftar Corona\n§aTap to Open");
          $form->addButton("×§l§bSebar Corona\n§aTap to Open");
          $form->addButton("×§l§bBlink Stab Orang\n§aTap to Open");
          $form->addButton("×§l§bInjeksi Racun ke orang\n§aTap to Open");
          $form->sendToPlayer($sender);
          
       }

    public function CovidUI($sender){
	    $formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $formapi->createCustomForm(function(Player $sender, $data){
              if( !is_null($data)) {
                 switch($data[0]) {
               case 0:
                $sender->setGamemode(Player::SURVIVAL);
                $sender->addTitle("§bKamu Jadi", "§aMakhluk biasa");
                    break;
                case 1:
                $sender->setGamemode(Player::CREATIVE);
                $sender->addTitle("§bKamu Bisa", "§aMelakukan Segalanya");
                    break;
                case 2:
                $sender->setGamemode(Player::SPECTATOR);
                $sender->addTitle("§bKamu jadi", "§aMalaikat Pengawas");
                    break;
               default:
                   return;
            }
  }

    });
    $form->setTitle("§5GAMEMODES");
    $form->addDropdown("§fGamemodes", ["§aSurvival", "§aCreative", "§aSpectator"]);
    $form->sendToPlayer($sender);
    
    }
    
    
    public function Sn(Player $sender){
    	$list = [];
        foreach($this->getServer()->getOnlinePlayers() as $p) {
        	$list[] = $p->getName();

        }
        
        $this->Kiled[$sender->getName()] = $list;
    
    	$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $player, array $data = null){
        if($data === null){
                return true;
            }
 
            //whattsap men
            
            $index = $data[0];
            $PlayerName = $this->Kiled[$player->getName()][$index];    
            $this->getServer()->getCommandMap()->dispatch($player, "kill " . $PlayerName);
            $player->sendMessage("§l§bPilih Player Yang Mau Di Santet §d⛏" . $PlayerName);
            $player->addTitle("§l§aTerSantet\n §6A §b⛏" . $PlayerName);

         });	
         $form->setTitle("§l§bSantet");
         $form->addDropdown("§aPilih Playernya!⛏ §b", $this->Kiled[$sender->getName()]);
         $form->sendToPlayer($sender);
    return $form;
     }
    
    public function Heal($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
                    $sender->setHealth(20);
                    $sender->setFood(20);
                    $sender->sendMessage("§l§dDarah Dan Makanan Telah Full!⛏");
                    $sender->addTitle("§l§5Anda telah", "§l§bSEMBUH");
                break;
                
                }
            });
            $form->setTitle("§l§dCorona");
            $form->setContent("§l§b➛ §dHai §f" . $sender->getName() . "\n §aWelcome to Covid Menu⛏");
            $form->addButton("§l§bBoom Sembuh!");
            $form->sendToPlayer($sender);
           
    }
 }
