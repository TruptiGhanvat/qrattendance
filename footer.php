 <!-- Footer Start -->
 <div class="container-fluid pt-4 px-4">
     <div class="bg-light rounded-top p-4">
         <div class="row">
             <div class="col-12 col-sm-6 text-center text-sm-start">
                 &copy; <a href="#">Student Attendance System Using QR Code</a>, All Right Reserved.
             </div>
         </div>
     </div>
 </div>
 <!-- Footer End -->
 </div>
 <!-- Content End -->


 <!-- Back to Top -->
 <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
 </div>

 <!-- JavaScript Libraries -->
 <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
 <script src="lib/chart/chart.min.js"></script>
 <script src="lib/easing/easing.min.js"></script>
 <script src="lib/waypoints/waypoints.min.js"></script>
 <script src="lib/owlcarousel/owl.carousel.min.js"></script>
 <script src="lib/tempusdominus/js/moment.min.js"></script>
 <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
 <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

 <!-- Template Javascript -->
 <script src="js/main.js"></script>

 <script>
     new DataTable('#table', {
         layout: {
             topStart: {
                 buttons: [{
                         extend: 'print',
                         exportOptions: {
                             columns: ':visible'
                         }
                     },
                     'colvis'
                 ]
             }
         },
         columnDefs: [{
             targets: 0,
             visible: false
         }]
     });
 </script>
 </body>

 </html>