<div class="container" >
    <h2>Страници</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Заглавие</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
    <?php foreach($pages AS $page){ ?>
        <tr>
            <td><?= $page['id']?></td>
            <td><?= $page['title']?></td>
            <td><?= $page['category']?></td>
            <td><a href="edit.php?id=<?=$page['id']?>"> редактиране</a> <?=($page['active']==1)?' ( Активна )':' ( Спряна )'?></td>
        </tr>

    <?php } ?>

        
        
        </tbody>
    </table>



</div>