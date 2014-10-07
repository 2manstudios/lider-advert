<p><a href="/x-files">Админка</a> -> Региональные данные сайта</p>
<h3>Просмотр наших региональных данных</h3>
<form action="" method="POST">
    
    <table>
        <caption><strong>Регион</strong></caption>
        <tr>
            <td>
                <strong>Область</strong><br>                
                <select name="region" id="region">
                    <option value="0">-Выберите-</option>
                    <?php foreach($region_data AS $k => $v): ?>
                    <option value="<?php echo $v['id']; ?>" ><?php echo $v['name']; ?></option>
                    <?php endforeach; ?>        
                </select>
            </td>
            <td>
                <strong>НП-1</strong><br>
                <select name="district" id="district" style="display:none;">        
                </select>
            </td>
            <td>
                <strong>НП-2</strong><br>
                <select name="town" id="town" style="display:none;">        
                </select>
            </td>
            <td>
                <strong>МикроРайон</strong><br>
                <select name="microDistrict" id="micro" style="display:none;">        
                </select>
            </td>            
            <td>
                <strong>Улица</strong><br>
                <select name="street" id="street" style="display:none;">        
                </select>
            </td>
        </tr>
        <tr style="font-size: 10px;">
            <td>
                <!--<strong>Удалить</strong> <br> <input type="radio" name="del_region" value="1" id="dreg"><label for="dreg"> - Все</label> :: <input type="radio" name="del_region" value="2" id="dreg2"><label for="dreg2"> - Выбр.</label>-->
            </td>
            <td>
                <strong>Удалить</strong>  <br> <!--<input type="radio" name="del_district" value="1" id="ddis"><label for="ddis"> - Все</label> ::--> <input type="checkbox" name="del_district" value="2" id="ddis2"><label for="ddis2"> - Выбр.</label>
            </td>
            <td>
                <strong>Удалить</strong> <br> <input type="radio" name="del_town" value="1" id="dtown"><label for="dtown"> - Все</label> :: <input type="checkbox" name="del_town" value="2" id="dtown2"><label for="dtown2"> - Выбр.</label>
            </td>
            <td>
                <strong>Удалить</strong>  <br> <!--<input type="radio" name="del_micro" value="1" id="dmicro"><label for="dmicro"> - Все</label> ::--> <input type="checkbox" name="del_micro" value="2" id="dmicro2"><label for="dmicro2"> - Выбр.</label>
            </td>
            <td>
                <strong>Удалить</strong>  <br> <!--<input type="radio" name="del_street" value="1" id="dstreet"><label for="dstreet"> - Все</label> ::--> <input type="checkbox" name="del_street" value="2" id="dstreet2"><label for="dstreet2"> - Выбр.</label>
            </td>
        </tr>
    </table>    
    
    <fieldset style="border:1px solid black;margin: 2px;padding: 2px;">
        <legend><strong>Добавление данных</strong></legend>
        
        <table>
            <tr>
                <td>
                    <strong>НП-1</strong><br>
                    <textarea name="new_district"></textarea>
                </td>
                <td>
                    <strong>НП-2</strong><br>
                    <textarea name="new_town"></textarea>
                </td>                
                <td>
                    <strong>Микрорайоны</strong><br>
                    <textarea name="new_microDistrict"></textarea>
                </td>
                <td>
                    <strong>Улицы</strong><br>
                    <textarea name="new_street"></textarea>
                </td>                
            </tr>
        </table>
        
    </fieldset>
    
    <input type="submit" name="our_data" value="Подтвердить" >
</form>