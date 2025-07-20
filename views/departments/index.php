<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Отделы</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/departments/create" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-plus-circle"></i> Добавить отдел
            </a>
        </div>
    </div>
</div>

<?php if (!empty($departments)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Количество пользователей</th>
                    <th>Дата создания</th>
                    <th>Дата обновления</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department): ?>
                    <tr>
                        <td><?= $department['id'] ?></td>
                        <td><?= htmlspecialchars($department['name']) ?></td>
                        <td><?= htmlspecialchars($department['description'] ?? '-') ?></td>
                        <td>
                            <span class="badge bg-info"><?= $department['user_count'] ?? 0 ?></span>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($department['created_at'])) ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($department['updated_at'])) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/departments/<?= $department['id'] ?>" 
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/departments/<?= $department['id'] ?>/edit" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="/departments/<?= $department['id'] ?>/delete" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('Вы уверены, что хотите удалить этот отдел?')">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Отделов пока нет. 
        <a href="/departments/create" class="alert-link">Создайте первый отдел</a>.
    </div>
<?php endif; ?>