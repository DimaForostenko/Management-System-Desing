<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Пользователи</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/users/create" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-plus-circle"></i> Добавить пользователя
            </a>
        </div>
    </div>
</div>

<!-- Фильтры -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Поиск</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                               placeholder="Имя или email">
                    </div>
                    <div class="col-md-3">
                        <label for="department" class="form-label">Отдел</label>
                        <select class="form-select" id="department" name="department">
                            <option value="">Все отделы</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>" 
                                        <?= ($_GET['department'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dept['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Статус</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Все</option>
                            <option value="1" <?= ($_GET['status'] ?? '') === '1' ? 'selected' : '' ?>>Активные</option>
                            <option value="0" <?= ($_GET['status'] ?? '') === '0' ? 'selected' : '' ?>>Неактивные</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Фильтр
                            </button>
                            <a href="/users" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Сбросить
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($users)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Отдел</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Дата обновления</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['department_name'] ?? 'Не указан') ?></td>
                        <td>
                            <span class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                                <?= $user['is_active'] ? 'Активный' : 'Неактивный' ?>
                            </span>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($user['updated_at'])) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/users/<?= $user['id'] ?>" 
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/users/<?= $user['id'] ?>/edit" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="/users/<?= $user['id'] ?>/delete" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?')">
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
        <i class="bi bi-info-circle"></i> Пользователей не найдено. 
        <a href="/users/create" class="alert-link">Создайте первого пользователя</a>.
    </div>
<?php endif; ?>