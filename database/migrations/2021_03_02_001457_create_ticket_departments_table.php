<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class CreateTicketDepartmentsTable extends Migration
   {

       /**
        * Run the migrations.
        *
        * @return void
        */
       public function up()
       {
           Schema::create('ticket_departments', function (Blueprint $table) {
               $table->id();
               $table->foreignId('ticket_id')->unsigned()->nullable()->constrained('tickets')->onDelete('set null');
               $table->binary('additional_departments');
               $table->timestamps();
           });
       }

       /**
        * Reverse the migrations.
        *
        * @return void
        */
       public function down()
       {
           Schema::dropIfExists('ticket_departments');
       }

   }
   