<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= htmlspecialchars($department['name']) ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/departments/<?= $department['id'] ?>/edit" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil"></i> Редактировать
            </a>
            <a href="/departments" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Назад к списку
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Информация об отделе</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td><?= $department['id'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Название:</strong></td>
                        <td><?= htmlspecialchars($department['name']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Описание:</strong></td>
                        <td><?= htmlspecialchars($department['description'] ?? 'Не указано') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Дата создания:</strong></td>
                        <td><?= date('d.m.Y H:i', strtotime($department['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Дата обновления:</strong></td>
                        <td><?= date('d.m.Y H:i', strtotime($department['updated_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Пользователи отдела</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($users)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td>
                                            <span class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                                                <?= $user['is_active'] ? 'Активный' : 'Неактивный' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="/users/<?= $user['id'] ?>" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">В этом отделе пока нет пользователей.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>