<h1 class="o-title"><?=$page_title?></h1>

<?php if (isset($s_success) && !empty($s_success)): ?>
    <div class="message success"><?=$s_success?></div>
<?php endif; ?>
<?php if (isset($s_error) && !empty($s_error)): ?>
    <div class="message error"><?=$s_error?></div>
<?php endif; ?>

<table>
    <thead>
        <th>ID</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Info</th>
        <th>Status</th>
        <th>Dated</th>
    </thead>
    <tbody>
        <?php if (!empty($transactions)): ?>
            <?php foreach($transactions as $transaction): ?>
                <tr>
                    <td><?=$transaction['otransaction_id']?></td>
                    <td><?=get_otransaction_type_text($transaction['otransaction_type'])?></td>
                    <td>
                        <?=$transaction['otransaction_amount']?> Codn<br>
                        <small>Balance Previous - <?=$transaction['otransaction_previous_balance']?> Codn</small><br>
                        <small>Balance After - <?=$transaction['otransaction_current_balance']?> Codn</small>
                    </td>
                    <td><?=$transaction['otransaction_info']?></td>
                    <td><?=get_otransaction_status_text($transaction['otransaction_status'])?></td>
                    <td><?=normal_date($transaction['otransaction_created'])?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="6">No transactions found</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
