<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= htmlspecialchars($user['name']) ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil"></i> Редагувати
            </a>
            <a href="/users" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Назад до списку
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Информація про користувача</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td><?= $user['id'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Ім'я:</strong></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                    </tr>
                                <td><strong>Email:</strong></td>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($user['email']) ?>" class="text-decoration-none">
                                <?= htmlspecialchars($user['email']) ?>
                            </a>
                        </td>
                    </tr>
                    <?php if (isset($user['phone'])): ?>
                    <tr>
                        <td><strong>Телефон:</strong></td>
                        <td>
                            <?php if ($user['phone']): ?>
                                <a href="tel:<?= htmlspecialchars($user['phone']) ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($user['phone']) ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Не вказано</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Департамент:</strong></td>
                        <td>
                            <?php if ($user['department_name']): ?>
                                <a href="/departments/<?= $user['department_id'] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($user['department_name']) ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Не вказано</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                          <?php if (isset($user['position'])): ?>
                    <tr>
                        <td><strong>Посада:</strong></td>
                        <td>
                            <?php if ($user['position']): ?>
                                <?= htmlspecialchars($user['position']) ?>
                            <?php else: ?>
                                <span class="text-muted">Не вказано</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><strong>Статус:</strong></td>
                        <td>
                            <span class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                                <?= $user['is_active'] ? 'Активний' : 'Неактивний' ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Дата створення:</strong></td>
                        <td><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Дата оновлення:</strong></td>
                        <td><?= date('d.m.Y H:i', strtotime($user['updated_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Дії</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/users/<?= $user['id'] ?>/edit" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Редагувати
                    </a>
                    <form method="POST" action="/users/<?= $user['id'] ?>/delete" 
                          onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?')">
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Видалити
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>