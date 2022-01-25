<?php defined('SITE') OR exit('Неразрешен директен достъп!'); ?>

<div class="container mt-5 mb-5 pb-5">
<?= $this->show_errors() ?>
    <div class="row mt-5 mb-5 pb-5">
        
        <div class="col-md-5 offset-3 pb-5">
            <h2>Вход!</h2>
            <p>Само за администратори!!</p>
            <?=(isset($errors))? '<p>'.implode('<br>',$errors).'</p>':'';?>
            <form action="" method="post">
                <input type="hidden" name="protect" value="<?= $protect;?>">
                <div class="form-group">
                    <label for="usr">Потребителско име:</label>
                    <input type="text" name="username" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="pwd">Парола:</label>
                    <input type="password" name="password" class="form-control" id="pwd">
                </div>
                <button type="submit" name="submit" value="login" class="btn btn-success float-right" id="pwd">Вход!</button>

            
            </form>
        </div>
    </div>

</div>