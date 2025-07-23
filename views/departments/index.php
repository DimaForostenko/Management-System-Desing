<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Департаменти</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/departments/create" class="btn btn-sm btn-outline-secondary">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
                <i class="bi bi-plus-circle"></i> Додати департамент
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
                    <th>Назва</th>
                    <th>Опис</th>
                    <th>Кількість співробітників</th>
                    <th>Дата створення</th>
                    <th>Дата оновлення</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department): ?>
                    <tr>
                        <td><?= $department['id'] ?></td>
                        <td>
                            <a href="/departments/<?= $department['id'] ?>" class="text-decoration-none">
                                <?= htmlspecialchars($department['name']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($department['description'] ?? '-') ?></td>
                        <td>
                            <span class="badge bg-info">
                                <?= (int)$department['users_count'] ?> чел.
                            </span>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($department['created_at'])) ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($department['updated_at'])) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/departments/<?= $department['id'] ?>"
                                   class="btn btn-sm btn-outline-info"
                                   title="Огляд">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/departments/<?= $department['id'] ?>/edit"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Редагувати">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php if ((int)$department['users_count'] === 0): ?>
                                    <form method="POST" action="/departments/<?= $department['id'] ?>/delete"
                                          style="display: inline;"
                                          onsubmit="return confirm('Вы уверены, что хотите удалить этот отдел?')">
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                title="Видалити">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger disabled"
                                            title="Не можна видалити департамент зі співробітниками"
                                            disabled>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        <small class="text-muted">
            Всього департаментів: <?= count($departments) ?>
        </small>
    </div>
    
<?php else: ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Департаментів поки що не має
        <a href="/departments/create" class="alert-link">Створити перший департамент</a>.
    </div>
<?php endif; ?>
