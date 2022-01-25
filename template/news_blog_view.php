<div class="container" data-aos="fade-up">
    <?php foreach($last_news AS $news){?>
        <div class="row">
            <a href="news.php?id=<?= $news['id']?>">
                <h3><?=$news['title']?></h3>
                <h5> <?= $news['summary']?><h5>
                    
            </a>
            
        </div>
        <hr>
   <?php }?>
</div>