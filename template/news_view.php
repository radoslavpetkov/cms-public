<?php 
  defined('SITE') OR exit('Неразрешен директен достъп');
?>
<div class="container" data-aos="fade-up">
        <h1><?=$singe_news['title']?></h1>
        <h4><?=$singe_news['summary']?></h4>
        <h5><?= date('d.m.Y  (H:i часа)', strtotime($singe_news['timestamp']));?></h5>
        <p>
          <?=$singe_news['content'] ?>
        </p>

        
        
</div>