<section class="search">
<?php
foreach ($results as $result) {
?>
<article class="item">
    <h3>
        <a href="<?php echo $result['url'];?>"><?php echo $result['title'];?></a>
    </h3>
    <p class="descript"><?php echo $result['date'];?></p>
    <p class="label"><?php echo $result['tags'];?></p>
    <p class="descript"><?php echo $result['description'];?></p>
</article>
<?php
}
?>
</section>
