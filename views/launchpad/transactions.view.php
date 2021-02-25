<div class="page">
    <div class="page-title">
        <div class="page-title-left">
            <h1><span>Transactions</span></h1>
        </div>
    </div>
    <div class="page-content">

        <div class="dashboard-content">
           
            <div class="dashboard-content-title">
                <h2>Recent</h2>
            </div>

            <table>
                <thead>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Info</th>
                    <th>Dated</th>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach($transactions as $transaction): ?>
                            <tr>
                                <td><?=$transaction['mt_id']?></td>
                                <td><?=get_otransaction_type_text($transaction['mt_type'])?></td>
                                <td>
                                    <?=$transaction['mt_amount']?> Codn<br>
                                    <small>Balance Previous - <?=$transaction['mt_previous_balance']?> Codn</small><br>
                                    <small>Balance After - <?=$transaction['mt_current_balance']?> Codn</small>
                                </td>
                                <td><?=$transaction['mt_info']?></td>
                                <td><?=normal_date($transaction['mt_created'])?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">No transactions found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="dashboard-content-link">
                <a href="<?=URL?>/launchpad/dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Back to dashboard</a>
            </div>
        </div>

    </div>
</div>
