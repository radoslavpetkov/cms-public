<?php   defined('SITE') OR exit('Неразрешен директен достъп'); ?>

<div class="container">
    <?= $this->show_errors() ?>
    <h2>Редактиране</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?=$page_data['id']?>">
        
        <!-- Активна или не -->
        <input type="hidden" name="active" value="0">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="active" value="1" id="active" <?=($page_data['active']==1)?'checked':''?>>
            <label class="form-check-label" for="active">
                Пускане / Спиране
            </label>
        </div>
        <!-- заглавие -->
        <div class="form-group">
            <label for="title">Заглавие:</label>
            <input type="text" id="title" name="title" value="<?=$page_data['title'];?>" style="width: 100%;" required>
        </div>
        <!-- кратък текст -->
        <div class="form-group">
            <label for="summary">Кратък текст:</label>
            <input type="text" name="summary" value="<?=$page_data['summary'];?>" id="summary" style="width: 100%;" required>
        </div>
         <!-- категория  -->
         <div class="form-group">
             <label for="category">Категория</label>
             <select name="category_id" id="category" style="width: 100%;" required>
                 <?php foreach($categories AS $category){?>
                    <option value="<?=$category['id']?>" <?=($category['id'] == $page_data['category_id']) ?'selected':''?>><?=$category['name']?> </option>
                 <?php } ?>
             </select>
         </div>
         <!-- съдържание -->
         <div class="form-group">
             <textarea name="content" id="content" cols="30" rows="20" style="width: 100%;" required><?= $page_data['content']?></textarea>
         </div>
        <button class="btn btn-success" type="submit" name="edit" value="save">Запис</button>
        
        <script src="ckeditor/ckeditor.js"></script>
        <script>
        CKEDITOR.replace('content', {
            extraPlugins: 'filetools',
            extraPlugins: 'popup',
			filebrowserBrowseUrl: 'ck_browse.php?type=Images&dir=' + encodeURIComponent('../images/'),
			filebrowserUploadUrl: 'ck_upload.php',
			filebrowserUploadMethod: 'form'
			
		});
		CKEDITOR.config.contentsCss = '/ckeditor/css/style.css' ; 
        </script>



    </form>



</div>