<h3>Регистрация</h3>
<form action="" method="POST">
    <table>
        <tr>
            <td>Имя</td>
            <td>
                <input type="text" name="name">
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <input type="text" name="email">
            </td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td>
                <input type="text" name="phone">
                <br><small>Будет отправлен код</small>
            </td>
        </tr>
        <tr>
            <td>Пароль</td>
            <td>
                <input type="password" name="pass">
            </td>
        </tr>
        <tr>
            <td>Подтвердите пароль</td>
            <td>
                <input type="password" name="pass2">
            </td>
        </tr>        
        <tr>
            <td>Получать рассылку новостей</td>
            <td>
                <input type="checkbox" name="confirm" checked>
            </td>
        </tr>               
        <tr>
            <td colspan="2">
                <input type="submit" name="ok" value="Подтвердить">
            </td>
        </tr>
    </table>
</form>