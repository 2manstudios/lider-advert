<p><a href="/x-files">Админка</a> -> Перечень сайтов для публикации</p>

<table>    
    <thead>       
        <th>#</th>
        <th>Название</th>
        <th>Автопубликация</th> 
        <th>Примечание</th>
    </thead>
    <tbody>
        <?php foreach($data AS $k => $v): ?>
            <tr>
                <td><?php echo $k+1; ?></td>
                <td><?php echo $v['name']; ?></td>
                <td><?php echo ($v['status']) ? 'да' : 'нет'; ?></td>
                <td><?php echo $v['msg']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>        
</table>