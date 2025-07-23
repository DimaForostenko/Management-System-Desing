<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Створити користувача</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/users" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Назад до списку
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/users/create">
                    <div class="mb-3">
                        <label for="name" class="form-label">Ім'я *</label>
                        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                               id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                        <?php if (isset($errors['name'])): ?>
                            <div class="invalid-feedback"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                               id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= $errors['email'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="department_id" class="form-label">Департамент</label>
                        <select class="form-select <?= isset($errors['department_id']) ? 'is-invalid' : '' ?>" 
                                id="department_id" name="department_id">
                            <option value="">Виберіть департамент</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>" 
                                        <?= ($old['department_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dept['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['department_id'])): ?>
                            <div class="invalid-feedback"><?= $errors['department_id'] ?></div>
                        <?php endif; ?>
                    </div>
<div class="mb-3">
    <label for="phone" class="form-label">Телефон</label>
    <input type="tel" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
           id="phone" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
           placeholder="Введите номер телефона" maxlength="20">
    <?php if (isset($errors['phone'])): ?>
        <div class="invalid-feedback"><?= $errors['phone'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="position" class="form-label">Посада</label>
    <input type="text" class="form-control <?= isset($errors['position']) ? 'is-invalid' : '' ?>"
           id="position" name="position" value="<?= htmlspecialchars($old['position'] ?? '') ?>"
           placeholder="Введите должность" maxlength="100">
    <?php if (isset($errors['position'])): ?>
        <div class="invalid-feedback"><?= $errors['position'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="address" class="form-label">Адреса</label>
    <textarea class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
              id="address" name="address" rows="3" maxlength="1000"
              placeholder="Введите адрес"><?= htmlspecialchars($old['address'] ?? '') ?></textarea>
    <?php if (isset($errors['address'])): ?>
        <div class="invalid-feedback"><?= $errors['address'] ?></div>
    <?php endif; ?>
</div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   <?= ($old['is_active'] ?? '1') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Активний користувач
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Створити користувача
                        </button>
                        <a href="/users" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Відміна
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>