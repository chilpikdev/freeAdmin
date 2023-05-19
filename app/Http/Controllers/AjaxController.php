<?php

namespace App\Http\Controllers;

use App\Models\Admin\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AjaxController extends Controller
{
    /**
     * Delete file with ajax request
     */
    public function deleteFile(Request $request)
    {
        if ($request->ajax())
        {
            $tableName = $request->table;
            $id = $request->id;
            $fieldName = $request->fieldname;
            $fileName = $request->filename;

            $data = DB::table($tableName)->select($fieldName)->where('id', $id)->first();
            $value = [];

            if (!empty($data->{$fieldName})) {
                if (is_array(json_decode($data->{$fieldName})))
                {
                    foreach (json_decode($data->{$fieldName}) as $file) {
                        if ($fileName == $file) {
                            $file_path = public_path($file);

                            if (File::exists($file_path)) {
                                File::delete($file_path);
                            }
                        } else {
                            $value[] = $file;
                        }
                    }
                }
                else
                {
                    $file_path = public_path($data->{$fieldName});

                    if (File::exists($file_path)) {
                        File::delete($file_path);
                    }
                }
            }

            $value = (count($value) > 0) ? json_encode($value) : null;

            DB::table($tableName)->where('id', $id)->update([$fieldName => $value]);
        }
    }

    /**
     * Contact From Ajax
     */
    public function contactForm(Request $request)
    {
        if ($request->ajax())
        {
            $errors = [];
            $data = [];

            if (empty($_POST['name'])) {
                $errors['name'] = 'Name is required.';
            }

            if (empty($_POST['email'])) {
                $errors['email'] = 'Email is required.';
            }

            if (empty($_POST['comment'])) {
                $errors['comment'] = 'Comment is required.';
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {
                $data['success'] = true;
                $data['message'] = 'Thank you, we will contact you soon!';
            }

            if ($data['success'])
            {
                Subscribe::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'comment' => $request->comment,
                ]);
            }

            echo json_encode($data);
        }
    }

    /**
     * Broker Tab Activity
     */
    public function brokerTab(Request $request)
    {
        if ($request->ajax())
        {
            session()->put('individ_broker_activity', (bool) $request->individ);
            session()->put('business_broker_activity', (bool) $request->business);
        }
    }
}
