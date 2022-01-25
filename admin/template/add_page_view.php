<?php   defined('SITE') OR exit('Неразрешен директен достъп'); ?>

<div class="container">
    <?= $this->show_errors() ?>
    <h2>Редактиране</h2>
    <form action="" method="post">       
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
        <button class="btn btn-success" type="submit" name="addpage" value="save">Запис</button>
        
        <script src="ckeditor/ckeditor.js"></script>
        <script>
        CKEDITOR.replace('content', {
            extraPlugins: 'filetools',
            extraPlugins: 'popup',
			filebrowserBrowseUrl: 'ck_browse.php?type=Images&dir=' + encodeURIComponent('../images/'),
			filebrowserUploadUrl: 'ck_upload.php',
			filebrowserUploadMethod: 'form'
		});
        </script>



    </form>



</div>