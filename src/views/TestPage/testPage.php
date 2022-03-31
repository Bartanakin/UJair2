<?="Hello world but without Putin!";?>
<pre>
    <table>
        <?php foreach( $this -> params as $record): ?>
        <tr>
            <td><?= $record["ID"] ?></td>
            <td><?= $record["value1"] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</pre>
