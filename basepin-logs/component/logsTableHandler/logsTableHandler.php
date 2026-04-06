<?php 
include '../../include/logFunction.php';
include '../../include/auth_checker.php'
?>

<div class="table-wrapper" id="logsTableContainer">
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
                                <button type="button" class="sel_btn" data-id="<?= $row['id']; ?>"></button>

                               <button type="button" class="btn-view" onclick="openViewModal(<?php echo $row['id']; ?>)" title="View Details">
                                    <span class="material-icons-outlined">visibility</span>
                                </button>
                              
                                <?php if ($user_role === 'admin'): ?>
                                    <form method="POST" style="display:inline;" action="../../include/logFunction.php" class="delete-form">
                                        <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
                                        <input type="hidden" name="control_number" value="<?= htmlspecialchars($row['control_number']); ?>">
                                        
                                        <button type="submit" class="btn-delete" title="Delete Record" name="action_delete">
                                            <span class="material-icons-outlined">delete</span>
                                        </button>
                                    </form>
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
   <?php include '../../component/dashboardForm/dashboardFormModal.php'?>