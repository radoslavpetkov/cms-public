<?php   defined('SITE') OR exit('Неразрешен директен достъп'); ?>

<div class="container">
    <?= $this->show_errors() ?>
    <?= $this->show_success() ?>
    <h2>Файлове</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <input type="file" name="fileToUpload" class="form-control" id="">
            <div class="input-group-append">
                <button type="submit" name="upload" class="btn btn-success input-group-text">Качи!</button>
            </div>
        </div>

        <!-- <div class="form-group">
            <input type="file" name="fileToUpload" class="form-control" id="">
            <button type="submit" class="btn btn-success input-group-text">Качи!</button>

        </div> -->

    </form>

    <div class="row">

        <div class="card-group">
            <?php foreach($files AS $f){
                $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                if($ext == 'doc' OR $ext == 'docx'){
                    $img = BASE_URL.'/assets/img/doc.jpg';
                }elseif($ext == 'pdf'){
                    $img = BASE_URL.'/assets/img/pdf.jpg';
                }else{
                    $img = $f;
                }?>

                <div class="col-md-2" style="padding:5px; padding:5px;">
                    
                        <img class="card-img-top" src="<?=$img?>" alt="<?=$f?>">
                        <div class="card-body">
                            <p><a href="<?=$f?>" target="_blank" rel="noopener noreferrer">отвори</a></p>
                        </div>
                        
                </div>
            
            <?php }?> 
            </div>

        </div>



</div>