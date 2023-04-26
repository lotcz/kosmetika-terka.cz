<?php
	require_once __DIR__ . '/../../models/cosmetic-service-category.m.php';
	$this->setPageTitle('Test custom table data operations');

	if (z::isPost()) {

		if (z::get('delete', 0) == 1) {
			$test_id = z::getInt('test_id');
			TestModel::deleteById($this->z->db, $test_id);
			$this->message(sprintf('Record with id <strong>%s</strong> was deleted.', $test_id), 'danger');
		} else {
			$is_update = false;
			$test = new TestModel($this->z->db);
			$test_id = z::getInt('test_id');

			if (isset($test_id) && $test_id > 0) {
				$test->loadById($test_id);
				if ($test->is_loaded) {
					$is_update = true;
				}
			}

			$test->set('test_value', z::get('test_value'));

			if ($test->save()) {
				if ($is_update) {
					$this->message(sprintf('Record with id <strong>%s</strong> updated.', $test->val('test_id')), 'primary');
				} else {
					$this->message(sprintf('New record inserted with id <strong>%s</strong>.', $test->val('test_id')), 'success');
				}
			} else {
				$this->message('Record could not be saved.', 'error');
			}
		}
	}

	$this->setData('items', TestModel::all($this->z->db));
