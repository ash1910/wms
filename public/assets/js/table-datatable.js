$(function() {
	"use strict";

    $(document).ready(function() {
        $('#example').DataTable();
      } );


      $(document).ready(function() {
        var table = $('#example2').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
     
        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    } );

      $(document).ready(function() {
        var table = $('#example3').DataTable( {
            lengthChange: false,paging: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
     
        table.buttons().container()
            .appendTo( '#example3_wrapper .col-md-6:eq(0)' );
    } );

    $(document).ready(function() {
        var table4 = $('#example4').DataTable( {
            lengthChange: false, paging: false, ordering: false, searching: false, info: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );
     
        table4.buttons().container()
            .appendTo( '#example4_wrapper .col-md-6:eq(0)' );
    } );










});