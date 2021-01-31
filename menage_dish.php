<?php
require_once 'start.php';
global $dish_table;

function showTable(&$table){
    require_once "dbConfig.php";

    //Pobranie z bazy wszystkich dań
    if($dishes = $db->prepare("SELECT * FROM dania;")){
        $dishes->execute();
        $result = $dishes->get_result();
        $row_count = $result->num_rows;
        if($row_count > 0){
            //Wyrzucenie pobranych rekordów do tabeli
            while($row = $result->fetch_assoc()){
                echo '<tr>';
                echo '<td>'. $row['id'] .'</td>';
                echo '<td>'. $row['title'] .'</td>';
                echo '<td><button class="btn btn-primary type="button" value ="'. $row['id'] .'" >Edytuj</button></td>';
                echo '</tr>';

                //Utworzenie tablicy, 
                $table[$row['id']] = $row['title'];
            }
        }
        else{
            echo 'Błąd generawania tabeli z daniami';
        }       
    }  
}
?>
<html>

<body>
    <?php
    require_once 'header.php';
    ?>

    <div id="dishes" style="margin: 0 100">

        <input type="text" id="search_dish" placeholder="Wyszukaj dania" autocomplete="off"></input>

        <table id="dish_table">
            <thead>
                <th>Id</th>
                <th>Nazwa dania</th>
                <th><?php echo '<button class="btn btn-secondary type="button" value ="ADD" >Dodaj danie</button>' ?>
                </th>
            </thead>
            <tbody id="content_table">
                <?php
                    showTable($dish_table);
                ?>
            </tbody>
        </table>
    </div>

    <div id="choosed" style="margin: 0 100; display: none;">
        <p id="choose_header"></p>
        <h4 id="dish_name"></h4>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Wprowadź nazwę</span>
            </div>
            <textarea id="edit_name" class="form-control" aria-label="With textarea"></textarea>

            <div id="modify_buttons" class="input-group-append" style="display: none;">
                <button id="modify_dish" class="btn btn-success" type="button" value="modify">Zapisz zmiany</button>
                <button id="delete_dish" class="btn btn-danger" type="button" value="delete">Usuń danie z bazy</button>
            </div>
            <div id="add_buttons" class="input-group-append" style="display: none;">
                <button id="add_dish" class="btn btn-success" type="button" value="add">Dodaj danie do bazy</button>
            </div>
        </div>
        <small class="text-muted">Wprowadź nazwę dania od 3 do 255 znaków</small>
    </div>

    <script>
    // console.log("jjjo");

    //przerzucenie tablicy z php do js
    var dishTable = <?php echo json_encode($dish_table); ?>;
    var lastChoosedDish = "";


    function showUpdatedTable() {
        $("#content_table").empty();
        dish_table = "";
        $("#content_table").append(function(){
               <?php //showTable($dish_table); ?>
        });

    }

    // alert o statusie procesu dodawania edycji usuwania
    function showResult(mode, id) {
        switch (mode) {
            case 'add':
                alert("Dodano danie do bazy");
                break;
            case 'modify':
                alert("Zaktualizowano danie o numerze id " + lastChoosedDish);
                break;
            case 'delete':
                alert("Usunięto danie o numerze id " + lastChoosedDish);
                break;
        }
    }

    //Wybieranie dania przyciskiem edytuj
    $("#dishes").find(".btn").on('click', function() {
        //w val buttona jest id
        var value = lastChoosedDish = $(this).val();

        $("#choosed").show("slow");

        // zależnie czy wybierzemy Edytuj lub dodaj danie pokazuje nam inne pola dodawnai
        if (value == 'ADD') {
            $("#modify_buttons").hide();
            $("#add_buttons").show("slow");

            $("#choose_header").text('Dodaj danie: ');
            $("#dish_name").text('');
            $("#edit_name").val('');
        } else {
            $("#add_buttons").hide();
            $("#modify_buttons").show("slow");

            $("#choose_header").text('Wybrane danie: ');
            $("#dish_name").text(dishTable[value]);
            $("#edit_name").val(dishTable[value]);
        }
    });

    //Logika zapisz zmiany i usuń dane z bazy
    $("#choosed").find(".btn").on('click', function() {

        //modify, delete, add
        var option = $(this).val();
        var edited_name = $("#edit_name").val();

        //w przypadku jeśli istnieje jeszcze jakiś post to wyczyścić
        <?php 
            if(isset($_POST)){
                unset($_POST);
            }
        ?>
        $.ajax({
            type: 'POST',
            url: 'menage_dish_fnc.php',
            data: {
                id: lastChoosedDish,
                edited: edited_name,
                mode: option
            },
            success: function(result) {
                console.log(result);
                showResult(option, lastChoosedDish);
                showUpdatedTable();
            }
        });

    });

    //Dynamiczne wyszukiwanie Dania po nazwie
    $("#search_dish").on("keyup", function() {
        var value = $(this).val();

        $("table tr").each(function(index) {
            if (index !== 0) {
                $row = $(this);

                var $tdElement = $row.find("td:eq(1)");
                var id = $tdElement.text();
                var matchedIndex = id.indexOf(value);

                if (matchedIndex != 0) {
                    $row.hide();
                } else {
                    $row.show();
                }

            }
        });
    });
    </script>
</body>

</html>