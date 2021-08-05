<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Course;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Show;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CourseController extends AdminController
{
    protected function title()
    {
        return trans('Courses');
    }

    protected function grid()
    {
        //$userModel = config('admin.database.users_model');

        $grid = new Grid(new  Course());

        $grid->column('id', 'ID')->sortable();
        $grid->column('course_name', __('Course Name'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        // $grid->actions(function (Grid\Displayers\Actions $actions) {
        //     if ($actions->getKey() == 1) {
        //         $actions->disableDelete();
        //     }
        // });

        // $grid->tools(function (Grid\Tools $tools) {
        //     $tools->batch(function (Grid\Tools\BatchActions $actions) {
        //         $actions->disableDelete();
        //     });
        // });

        return $grid;
    }
    protected function detail($id)
    {
        $show = new Show(Course::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('course_name', __('Course Name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Course);

        $form->display('id', 'ID');
        $form->text('course_name', __(' Course Name'))->rules('required');
        // $form->display('created_at', __('Created at'));
        // $form->display('updated_at', __('Updated at'));

        // $form->saving(function (Form $form) {
        //     if ($form->password && $form->model()->password != $form->password) {
        //         $form->password = Hash::make($form->password);
        //     }
        // });

        return $form;
    }
}
