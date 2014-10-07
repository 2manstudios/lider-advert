<p><a href="/x-files">Админка</a> -> <a href="/x-files/site_data">Связь с данными других сайтов</a> -> Связь параметров</p>
<?php if(_TYPE_ && $data['our_id'] > 1): ?>
<p>
<form action="" method="POST">
    <table>
        <caption>Регион</caption>
        <tr>
            <?php if($data['our_id'] > 1): ?>
            <td>
                Область<br>                
                <select name="region" id="region">
                    <option value="0">-Выберите-</option>
                    <?php foreach($region_data AS $k => $v): ?>
                    <option value="<?php echo $v['id']; ?>" ><?php echo $v['name']; ?></option>
                    <?php endforeach; ?>        
                </select>
            </td>
            <?php endif; ?>
            <?php if($data['our_id'] > 2 ): ?>
            <td>
                НП-1<br>
                <select name="district" id="district" style="display:none;">        
                </select>
            </td>
            <?php endif; ?>
            <?php if($data['our_id'] > 3): ?>
            <td>
                НП-2<br>
                <select name="town" id="town" style="display:none;">        
                </select>
            </td>
            <?php endif; ?>
            <?php if($data['our_id'] > 3): ?>
            <td>МикроРайон
                <select name="microDistrict" id="micro" style="display:none;">        
                </select>
            </td>            
            <?php endif; ?>
          </tr>
    </table>    
    <input type="submit" name="ok" value="Подтвердить" >
</form>
</p>
<?php endif; ?>
<?php if($pid): ?>
<form action="" method="POST">    
<input type="hidden" name="pid" value="<?php echo $pid; ?>">
<input type="hidden" name="oid" value="<?php echo $data['our_id']; ?>">

<?php if(_TYPE_ && $data['our_id'] > 1): ?>
<input type="hidden" name="region" value="<?php echo $region; ?>">
<input type="hidden" name="district" value="<?php echo $district; ?>">
<input type="hidden" name="microDistrict" value="<?php echo $microDistrict; ?>">
<input type="hidden" name="town" value="<?php echo $town; ?>">
<?php endif; ?>

    <table>
        <caption>Переменная - <?php echo $data['label']; ?></caption>
        <thead>            
            <th>У нас</th>
            <th>У них</th>            
            <th>Обновить</th>
        </thead>
        <tbody>
            <?php foreach($data['data'] AS $k => $v): ?>
                <tr>
                    <td><?php echo $v['name']; ?></td>
                    <td><?php echo $v['vname']; ?></td>
                    <td>
                        <input type="text" name="param<?php echo $k; ?>[]" value=''>
                        <input type="hidden" name="param<?php echo $k; ?>[]" value="<?php echo $v['id']; ?>">
                        <input type="hidden" name="param<?php echo $k; ?>[]" value="<?php echo $v['vid']; ?>">
                        <input type="hidden" name="param<?php echo $k; ?>[]" value="<?php echo ($v['vid']) ? 'edit' : 'add'; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>        
    </table>
<?php if(_TYPE_ == 'auto'): ?>
Список данных для авто привязки
<div>
    <textarea name="data"></textarea>
</div>
<?php endif; ?>
    <input type="submit" name="addSiteValue" value="Подтвердить" >
</form>
<?php endif; ?>