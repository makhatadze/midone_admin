<?php

   namespace App\Traits;

   trait TicketFilters
   {

       protected $filters = [
           'filter-ticket-status' => 'status',
           'filter-ticket-department' => 'department'
       ];

       public function validateFilter(string $filter, $value)
       {
           if (!array_key_exists($filter, $this->filters) || empty($value)) {
               return false;
           }

           // Reflection Method Can be used too, but not needed since we already know method already exists.
           return $this->{$this->filters[$filter]}($value);
       }

       public function department($ticketStatus)
       {
           return true;
       }

       public function status($ticketStatus)
       {
           return in_array($ticketStatus, ['success', 'pending', 'closed']);
       }

       public function getRoutePathForFilter($referer)
       {
           if (false === is_string($referer)) {
               return false;
           }
           
           $explodedPath = explode('/', $referer);
           $fromRoute = end($explodedPath);
           
           return $fromRoute;
       }

   }
   