<?php
    class Pokemon {
        public $id;
        public $name;
        public $health;
        public $attack;
        public $defense;
        public $speed;
        public $imagename;

        public $isDead = false;
        public $latestDamage;

        function __construct($id, $name, $health, $attack, $defense, $speed, $imagename)
        {
            $this->id = $id;
            $this->name = $name;
            $this->health = $health;
            $this->attack = $attack;
            $this->defense = $defense;
            $this->speed = $speed;
            $this->imagename = $imagename;
        }

        public function DisplayPokemonInfo() {
            $imagePath = "images/" . $this->imagename;
            $customMsg;
            if($this->isDead){
                $customMsg = "No damage because is dead!";
            }else if(!$this->isDead && $this->latestDamage == 0){
                $customMsg = "Still no damage, full health!";
            }else{
                $customMsg = "You took ".$this->latestDamage." damage!";
            }//end of the if-else
            $returnString = "<p>" . $this->name . "</p>";
            $returnString .=    "<img src='$imagePath' height='200'>                            
                                <div id='pkmAInfo' style='border: black double 5px; display: inline-block; margin: 50px 60% 5% 10%; width: 12em; text-align: left; padding-left: 5%;'><p>".
                                $customMsg."</p>
                                <p><b>HEALTH </b>".$this->health."</p>
                                <p><b>ATTACK </b>".$this->attack."</p>
                                <p><b>DEFENSE </b>".$this->defense."</p>
                                <p><b>SPEED </b>".$this->speed."</p>
                                </div>";
    
            return $returnString;
        }



        public function Attack($otherPokemon) {
            $damage = 0;

            // Add the attack calculation logic of your choise
            // e.g. attack - defense
            if(!$otherPokemon->isDead){
                $damage = $otherPokemon->TakeDamage($this->attack, $otherPokemon);
                $this->latestDamage = $damage;
                return $this->latestDamage;
            }else{
                return 0;
            }//end of if-else 
        }

        // Game Logic methods
        public function TakeDamage($amount, $otherPokemon) {
            // Deal damage to this pokemon based on the $amount paramter
            
            // If the pokemon is already dead, no damage should be dealt
            
            // If the pokemons health becomes lower than 0, then set it to exactly 0
            /**Formula 
             * 
             * PORCENTAJE DE DAÑO A REDUCIR = ATTACK / (ATTACK+OTHER PKM DEFENSE)
             * DAÑO A RESTAR = REDONDEAR(ATTACK*PORCENTAJE)
             * DAÑO FINAL = ATTACK - DAÑO A RESTAR
             * 
             * F = ATTACK - (ROUND(ATTACK*(ATTACK/(ATTACK+OTHERDEFENSE))))
            */
            $finalDmg = $amount-(round($amount*($amount/($amount+$otherPokemon->defense))));
            $otherPokemon->health -= $finalDmg;
            if($otherPokemon->health <= 0){
                $otherPokemon->isDead = true;
                $otherPokemon->health = 0;
            }//end of if
            return $finalDmg;
        }//end of the function
        
    }
?>