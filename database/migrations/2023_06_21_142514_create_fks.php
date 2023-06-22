<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFks extends Migration
{

    public function up()
    {

        Schema::table('my_classes', function (Blueprint $table) {
            $table->foreign('class_type_id')->references('id')->on('class_types')->onDelete('set null');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('my_class_id')->references('id')->on('my_classes')->onDelete('cascade');
        });

        Schema::table('student_records', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('my_class_id')->references('id')->on('my_classes')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('dorm_id')->references('id')->on('dorms')->onDelete('set null');
            $table->foreign('my_parent_id')->references('id')->on('parent_records')->onDelete('cascade');
        });

        Schema::table('saving_transactions', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('student_records')->onDelete('cascade');
            $table->foreign('student_saving_id')->references('id')->on('student_savings')->onDelete('cascade');
        });

        Schema::table('saving_students', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('student_records')->onDelete('cascade');
        });

        Schema::table('staff_records', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('my_class_id')->references('id')->on('my_classes')->onDelete('cascade');
        });

        Schema::table('payment_records', function (Blueprint $table) {
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('receipts', function (Blueprint $table) {
            $table->foreign('pr_id')->references('id')->on('payment_records')->onDelete('cascade');
        });

        Schema::table('student_savings', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

        Schema::table('saving_transactions', function (Blueprint $table) {
            $table->foreign('student_saving_id')->references('id')->on('student_savings')->onDelete('cascade');
        });
    }

    public function down()
    {

    }
}
