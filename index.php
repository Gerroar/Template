<?php
    include_once("classes/Pokemon.php");

    session_start();

    // Create an array that can hold all of the different Pokemons
    $pokemons = [];

    // Populate the array with Pokemon objects
    if(empty($pokemons)) {
        $pokemons[] = new Pokemon(1, "Bulbasaur", 294, 49, 49, 45, "001_Bulbasaur.png");
        $pokemons[] = new Pokemon(4, "Charmander", 282, 52, 43, 65, "004_Charmander.png");
        $pokemons[] = new Pokemon(7, "Squirtle", 292, 48, 65, 43, "007_Squirtle.png");
        $pokemons[] = new Pokemon(13, "Weedle", 284, 35, 30, 50, "013_Weedle.png");
        $pokemons[] = new Pokemon(25, "Pikachu", 274, 55, 40, 90, "025_Pikachu.png");
        $pokemons[] = new Pokemon(52, "Meowth", 284, 45, 35, 90, "052_Meowth.png");
    }

    // The total amount of pokemons available in the array
    $totalPokemons = sizeof($pokemons);

    // Read the pokemon from stored sessions, if they exist, otherwise set the values to null
    $pokemonA = isset($_SESSION['pokemonA']) ? $_SESSION['pokemonA'] : null;
    $pokemonB = isset($_SESSION['pokemonB']) ? $_SESSION['pokemonB'] : null;

    // If the sessions are null, then get a new random pokemon from the array, clone it, and save it as a session
    if($pokemonA == null) {
        $pokemonA = clone $pokemons[rand(0, $totalPokemons - 1)];
        $_SESSION['pokemonA'] = $pokemonA;
    }

    if($pokemonB == null) {
        $pokemonB = clone $pokemons[rand(0, $totalPokemons - 1)];
        $_SESSION['pokemonB'] = $pokemonB;
    }

    // Check for the GET['action']
    $action = isset($_GET['action']) ? $_GET['action'] : null;


    // Action - Generate two new pokemons to be used for the battle
    if($action == "newPokemon") {
        // Select two new pokemon by random, and save them as sessions
        // HINT: Get inspired by the code on lines 27-35

        $pokemonA = clone $pokemons[rand(0, $totalPokemons - 1)];
        $pokemonB = clone $pokemons[rand(0, $totalPokemons - 1)];

        $_SESSION['pokemonA'] = $pokemonA;
        $_SESSION['pokemonB'] = $pokemonB;

        // Redirect to own page, to remove the get parameters (prevents calling same action on refresh in browser)
        header('location: ?');
        exit;
    }

    // Action - Make the two pokemon battle each other
    if($action == "fight") {
        // Make the two pokemon attack each other, by the use of the Attack() method in the pokemon Class

        // If one of the pokemons are dead, then nothing should happen

        $pokemonA->Attack($pokemonB);
        $pokemonB->Attack($pokemonA);

        // Redirect to own page, to remove the get parameters (prevents calling same action on refresh in browser)
        header('location: ?');
        exit;
    }
?>

<div style="display: flex; flex-direction: column; justify-content: center; text-align: center; margin: 20px;">
    <a href='?action=newPokemon'>Get New Pokemons</a><br>
    <a href='?action=fight'>Attack each other</a>
</div>

<div style="border: black solid 1px; display: flex; margin: 0 20% 0 20%;">

    <div style="flex-grow: 1; text-align: center;">
        <?php echo $pokemonA->DisplayPokemonInfo(); ?>
    </div>
    <div style="flex-grow: 1; text-align: center;">
        <?php echo $pokemonB->DisplayPokemonInfo(); ?>
    </div>
</div>

