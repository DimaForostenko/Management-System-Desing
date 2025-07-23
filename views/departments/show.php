<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= htmlspecialchars($department['name']) ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/departments/<?= $department['id'] ?>/edit" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil"></i> Редагувати
            </a>
            <a href="/departments" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Назад до списку
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Информація про департамент</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td><?= $department['id'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Назва:</strong></td>
                        <td><?= htmlspecialchars($department['name']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Опис:</strong></td>
                        <td><?= htmlspecialchars($department['description'] ?? 'Не вказано') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Дата створення:</strong></td>
                        <td><?= date('d.m.Y H:i', strtotime($department['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Дата оновлення:</strong></td>
                        <td><?= date('d.m.Y H:i', strtotime($department['updated_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Користувачі департаменту</h5>
                 <span class="badge bg-info"><?= $usersCount ?> чел.</span>
            </div>
            <div class="card-body">
                <?php if (!empty($users)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Ім'я</th>
                                    <th>Email</th>
                                    <th>Статус</th>
                                    <th>Дії</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['position'] ?? 'Не вказано') ?></td>
                                        <td>
                                            <span class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                                                <?= $user['is_active'] ? 'Активний' : 'Неактивний' ?>
                                            </span>
                                        </td>
                                   <td>
                                            <a href="/users/<?= $user['id'] ?>" 
                                               class="btn btn-sm btn-outline-info"
                                               title="Огляд">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/users/<?= $user['id'] ?>/edit" 
                                               class="btn btn-sm btn-outline-warning"
                                               title="Редагувати">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                        <div class="text-center py-4">
                        <i class="bi bi-people display-4 text-muted"></i>
                        <p class="text-muted mt-2">В цього департаменті не має співробітників.</p>
                        <a href="/users/add" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus"></i> Додати користувача
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>