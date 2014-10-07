<p><a href="/x-files">Админка</a> -> Связь с данными других сайтов</p>
<form action="" method="POST">
    Выберите сайт<br>
    <select name="site">
        <option></option>
        <?php foreach($site AS $k => $v): ?>
        <option <?php echo ($cSite == $v['id']) ? 'selected' : '' ; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" name="submitSite" value="Подтвердить">
</form>
<br>
<?php if($cSite): ?>
<form action="" method="POST">    
<input type="hidden" name="site" value="<?php echo $cSite; ?>">
    <table>
        <caption>Список переменных</caption>
        <thead>
            <th>Название</th>
            <th>У нас</th>
            <th>У них</th>
            <th>Операции</th>
        </thead>
        <tbody>
            <?php foreach($ourParams AS $k => $v): ?>
                <tr>
                    <td><?php echo $v['label']; ?></td>
                    <td><?php echo $v['var']; ?></td>
                    <td>
                        <input type="text" name="param<?php echo $k; ?>[]" value="<?php echo $v['svar']; ?>">
                        <input type="hidden" name="param<?php echo $k; ?>[]" value="<?php echo $v['oid']; ?>">
                        <input type="hidden" name="param<?php echo $k; ?>[]" value="<?php echo $v['pid']; ?>">                        
                        <input type="hidden" name="param<?php echo $k; ?>[]" value="<?php echo ($v['pid']) ? 'edit' : 'add'; ?>">
                    </td>
                    <td>           
                        <?php if($v['type2'] <= 1 && !$v['min_value'] && $v['pid']): ?>
                            <?php if($k > 4): ?>
                                <a href="/x-files/data_link/<?php echo $v['pid']; ?>">привязка</a>
                            <?php else: ?>            
                                <a href="/x-files/data_link/auto/<?php echo $v['pid']; ?>">привязка</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <input type="submit" name="addSiteVar" value="Подтвердить" >
</form>
<?php endif; ?>