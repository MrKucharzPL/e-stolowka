<?php
// Include calendar helper functions
include_once 'functions.php';
?>

<html>
<?php
require_once 'start.php';
?>


<body>
  <?php
  require_once 'header.php';
  ?>




<section>
    <div class="container-fluid">
    <div class="row">
    

        <div class="col-7">
          <div class="Kalendarz shadow rounded">	<div id="calendar_div">
          <?php echo WywolajKalendarz(); ?>
          </div>
          </div>

          <div class="Dania shadow rounded">
          <div class="card-header  text-center">
        ZAMÓWIONE DANIA 
         </div>
          <aside class="menu__ " id="lista_dan">
          <?php echo ZamowioneDania(); ?>		
         </aside>       
      
          </div> 
          </div>



      <div class="col-5">
		  <div class="Jadlospis full shadow rounded ">
    <div class="card-header text-center">
    STWÓRZ JADŁOSPIS 
    </div>

      <aside class="menu__ " id="lista_dan2">
      <?php echo StworzJadlospis(); ?>		
      </aside>     

          
		</div>		
</div>
</div>
        

 </div>
</section>
</body>

</html>