<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <?php foreach($cols as $column): ?>
                    <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                <?php endforeach; ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <?php foreach($cols as $col): ?>
                            <td><?= isset($row[$col]) ? htmlspecialchars($row[$col]) : 'N/A'; ?></td>
                        <?php endforeach; ?>
                        
                        <td class="action-column"> 
                            <div class="action-buttons">
                                
                                <?php if ($user_role === 'admin'): ?>
                                    <button class="sel_btn" name="sel_btn">Select</button>
                                <?php endif; ?>

                                <button class="btn-view" title="View Details">
                                    <span class="material-icons-outlined">visibility</span>
                                </button>
                               
                                <?php if ($user_role === 'admin'): ?>
                                    <button class="btn-delete" title="Delete Record">
                                        <span class="material-icons-outlined">delete</span>
                                    </button>
                                <?php endif; ?>
                                
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?= count($cols) + 1; ?>" class="no-data">No logs found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>