<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . '/controllers/RestController.php');
require(APPPATH . '/libraries/Format.php');

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Student_model', 'student_m');
    }

    //-------------------------------------- endpoint with db --------------------------------------
    public function student_get($id = null)
    {
        if ($id) {
            $dataStudents = $this->student_m->getStudent($id);
        } else {
            $dataStudents = $this->student_m->getStudent();
        }

        if ($dataStudents) {
            $this->response([
                'status' => true,
                'data' => $dataStudents
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'student not found'
            ], 404);
        }
    }

    public function student_delete($id)
    {
        $delete = $this->student_m->deleteStudent($id);

        if (!$delete) {
            $this->response([
                'status' => true,
                'message' => 'Successfully delete data'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Provide an id'
            ], 404);
        }
    }

    public function student_post()
    {
        $dataStudents = [
            'nim' => $this->post('nim'),
            'name' => $this->post('name'), 'major' => $this->post('major')
        ];

        $insert = $this->student_m->insertStudent($dataStudents);

        if (!$insert) {
            $this->response([
                'status' => true,
                'message' => 'successfully insert data'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to insert data'
            ], 400);
        }
    }

    public function student_put($id)
    {
        $dataStudents = [
            'nim' => '155410090',
            'name' => 'Surya Manggala',
            'major' => 'Teknik Mesin'
        ];

        $put = $this->student_m->updateStudent($dataStudents, $id);

        if (!$put) {
            $this->response([
                'status' => true,
                'message' => 'Successfully edit data',
                'data' => $dataStudents
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to edit data'
            ]);
        }
    }

    //-------------------------------------- endpoint without db --------------------------------------
    public function product_get($id = null)
    {
        $dataProduct = [
            [
                'id' => 1,
                'name' => 'Pepsodent',
                'qty' => 100
            ],
            [
                'id' => 2,
                'name' => 'Sabun',
                'qty' => 50
            ],
            [
                'id' => 3,
                'name' => 'Kain',
                'qty' => 10
            ]
        ];

        if ($id) {
            if (array_key_exists($id, $dataProduct)) {
                $this->response([
                    'status' => true,
                    'data' => $dataProduct[$id - 1]
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Provide an id'
                ], 404);
            }
        } else {
            $this->response([
                'status' => true,
                'data' => $dataProduct
            ], 200);
        }
    }

    public function product_delete($id)
    {
        $dataProduct = [
            [
                'id' => 1,
                'name' => 'Pepsodent',
                'qty' => 100
            ],
            [
                'id' => 2,
                'name' => 'Sabun',
                'qty' => 50
            ],
            [
                'id' => 3,
                'name' => 'Kain',
                'qty' => 10
            ]
        ];

        if ($id) {
            unset($dataProduct[$id - 1]);
            if (array_key_exists($id, $dataProduct)) {
                $this->response([
                    'status' => true,
                    'message' => 'Successfully delete product',
                    'data' => $dataProduct
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Provide an id'
                ], 404);
            }
        }
    }

    public function product_post()
    {
        $dataProduct = [
            [
                'id' => 1,
                'name' => 'Pepsodent',
                'qty' => 100
            ],
            [
                'id' => 2,
                'name' => 'Sabun',
                'qty' => 50
            ],
            [
                'id' => 3,
                'name' => 'Kain',
                'qty' => 10
            ]
        ];

        $newData = [
            'id' => (int)$this->post('id'),
            'name' => $this->post('name'),
            'qty' => (int)$this->post('qty')
        ];

        array_push($dataProduct, $newData);

        $this->response([
            'status' => true,
            'data' => $dataProduct,
            'message' => 'Successfully insert data product'
        ], 201);
    }

    public function product_put($id)
    {
        $dataProduct = [
            [
                'id' => 1,
                'name' => 'Pepsodent',
                'qty' => 100
            ],
            [
                'id' => 2,
                'name' => 'Sabun',
                'qty' => 50
            ],
            [
                'id' => 3,
                'name' => 'Kain',
                'qty' => 10
            ]
        ];

        $newData = [
            'id' => (int)$id,
            'name' => $this->post('name'),
            'qty' => (int)$this->post('qty')
        ];

        $insert = array_push($dataProduct, $newData);

        if ($id) {
            array_replace($dataProduct[$id - 1], $insert);
            if (array_key_exists($id, $dataProduct)) {
                $this->response([
                    'status' => true,
                    'message' => 'Successfully edit product',
                    'data' => $dataProduct
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Failed to edit product'
                ], 404);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Provide an id'
            ], 404);
        }
    }
}
