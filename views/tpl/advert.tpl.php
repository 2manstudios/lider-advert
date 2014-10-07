<form action="" method="POST">
    <table class="advertTable">
        <thead>
            <th style="background: none;width:200px;"></th>
            <th style="background: none;"></th>
        </thead>
        <tbody>
            <?php foreach($data AS $k => $v): ?>
            <tr>      
                <td class="<?php echo $v['var']; ?>"><strong><?php echo $v['label']; ?></strong></td>            
                <?php if(isset($v['data']) && is_array($v['data'])): ?>
                <td class="<?php echo $v['var']; ?>">
                    <?php if($v['type2'] == 1): ?>
                    <select name="<?php echo $v['var']; ?>" id="<?php echo array_shift(explode("_", $v['var'])); ?>">
                    <?php endif; ?>           
                    <?php foreach($v['data'] AS $k2 => $v2): ?>                
                        <?php if($v['type2'] == 0): ?>
                            <span><input <?php echo (!$k2) ? "checked" : ''; ?> type="radio" name="<?php echo $v['var']; ?>" id="<?php echo $v['var']."-".$v2['id']; ?>" value="<?php echo $v2['id']; ?>"><label for="<?php echo $v['var']."-".$v2['id']; ?>"> - <?php echo $v2['name']; ?></label></span>
                        <?php elseif($v['type2'] == 1): ?>
                            <option value="<?php echo $v2['id']; ?>"><?php echo $v2['name']; ?></option>
                        <?php endif; ?>                                    
                    <?php endforeach; ?>
                    <?php if($v['type2'] == 1): ?>
                        </select>
                    <?php endif; ?>           
                </td>
                <?php else: ?>
                <td class="<?php echo $v['var']; ?>">
                    <?php if($v['type2'] == 1): ?>
                        <select name="<?php echo $v['var']; ?>" id="<?php echo $v['var']; ?>">
                            <?php for($i = $v['min_value']; $i <= $v['max_value']; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    <?php elseif($v['type2'] == 2): ?>
                        <input type="text" name="<?php echo $v['var']; ?>" id="<?php echo $v['var']; ?>">                    
                    <?php elseif($v['type2'] == 3): ?>
                        <textarea name="<?php echo $v['var']; ?>" id="<?php echo $v['var']; ?>"></textarea>
                    <?php endif; ?>                                    
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>            
        </tfoot>
    </table>
    
    <input type="submit" value="Подтвердить" >
</form>