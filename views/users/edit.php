<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Редактировать пользователя</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/users/<?= $user['id'] ?>" class="btn btn-sm btn-outline-info">
                <i class="bi bi-eye"></i> Просмотр
            </a>
            <a href="/users" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Назад к списку
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/users/<?= $user['id'] ?>">
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя *</label>
                        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                               id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? $user['name']) ?>" required>
                        <?php if (isset($errors['name'])): ?>
                            <div class="invalid-feedback"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                               id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? $user['email']) ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= $errors['email'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="department_id" class="form-label">Отдел</label>
                        <select class="form-select <?= isset($errors['department_id']) ? 'is-invalid' : '' ?>" 
                                id="department_id" name="department_id">
                            <option value="">Выберите отдел</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>" 
                                        <?= ($old['department_id'] ?? $user['department_id']) == $dept['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dept['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['department_id'])): ?>
                            <div class="invalid-feedback"><?= $errors['department_id'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   <?= ($old['is_active'] ?? $user['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Активный пользователь
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Сохранить изменения
                        </button>
                        <a href="/users/<?= $user['id'] ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>