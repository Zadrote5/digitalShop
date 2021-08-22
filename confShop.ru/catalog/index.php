<?





$allItems =  $connect->query("SELECT * FROM shop.products ");



foreach ($allItems as $allItems){
?>
<div class="card1 bg-dark mt-5 mb-5">
  <div class="img-wrap1">
  <img  src="img/<?=$allItems['image'];?>" width=300 height=300 alt="picture">
  </div>
  <div class="content-wrap1">
    <h3 class="title1"><?=$allItems['name'];?></h3>
      <p class="price1"><?=$allItems['price'];?>$</p>
      <p class="description1"><?=$allItems['description'];?></p>
        <div class="toggle-wrap1">
          <a class="toggle-buy1" href="#">BUY</a>
          <a class="toggle-info1" href="?del=<?=$allItems['id'];?>">Delete</a>
        </div>
  </div>
</div>


<?
}
?>