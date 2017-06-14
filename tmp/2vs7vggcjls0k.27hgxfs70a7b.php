<link href="<?php echo $BASE; ?>/ui/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="<?php echo $BASE; ?>/ui/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="<?php echo $BASE; ?>/ui/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

<div class="row">
  <style type="text/css">
   .notchecked {
    background-color: #fdd4d4!important;
  }
</style>
<div class="col-lg-12">
  <div class="ibox float-e-margins">
    <div class="ibox-title">
      <h5>Все мои домашние задания <small class="m-l-sm">Непроверенные работы выделены красным цветом, скоро их обязательно проверят.</small></h5>

    </div>
    <div class="ibox-content">

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example" style="font-size:13px;">
          <thead>
            <tr>

              <th>Дисциплина</th>
              <th>Преподаватель</th>
              <th>Ссылка на файл</th>
              <th>Описание</th>
              <th>Дата загрузки</th>
              <th>Дата проверки</th>
              <th>Оценка</th>
              <th>Комментарий преподавателя</th>

            </tr>
          </thead>
          <tbody>
           <?php foreach (($homework?:array()) as $v): ?>

            <tr <?php echo $v['checked']==0 ? 'class="notchecked"' : ''; ?>>
              <form data-id="<?php echo $v['id']; ?>">


                <td><?php echo $v['subject']; ?></td>
                <td><?php echo $v['fullname']; ?></td>
                <td><a href="<?php echo $v['route']; ?>" target="_blank"><?php echo $v['filename']; ?></a></td>
                <td><?php echo $this->raw(($v['student_comment'])); ?></td>
                <td><?php echo $v['uploadtime']; ?></td>
                <td><?php echo $v['checktime']; ?></td>
                <td><?php echo $v['mark']; ?></td>



                <td><?php echo $this->raw(($v['teacher_comment'])); ?></td>





              </form>  
            </tr>	


          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>

            <th>Дисциплина</th>
            <th>Преподаватель</th>
            <th>Ссылка на файл</th>
            <th>Описание</th>
            <th>Дата загрузки</th>
            <th>Дата проверки</th>
            <th>Оценка</th>
            <th>Комментарий преподавателя</th>

          </tr>
        </tfoot>
      </table>
    </div>

  </div>
</div>
</div>

</div>
<div class="modal inmodal in" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content animated bounceInRight">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Комментарий</h4>
      </div>
      <div class="modal-body">
       <div class="summernote" >
       </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" id="saveComment">Сохранить</button>
    </div>
  </div>
</div>
</div>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>      
<script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo $BASE; ?>/ui/js/plugins/ladda/spin.min.js"></script>
<script src="<?php echo $BASE; ?>/ui/js/plugins/ladda/ladda.min.js"></script>
<script src="<?php echo $BASE; ?>/ui/js/plugins/ladda/ladda.jquery.min.js"></script>
<!-- Page-Level Scripts -->
<script>
 function adjustHeight(el){
   el.style.height = (el.scrollHeight > el.clientHeight) ? (el.scrollHeight)+"px" : "60px";
 }
 $(document).ready(function(){

  $('form').keydown(function(event){
   if(event.keyCode == 13) {
     event.preventDefault();
     return false;
   }
 });





});

 $( '.edit' ).on("click", function(){
   var l = $(this).ladda();

		          // Start loading
		          l.ladda( 'start' );
              var id = $(this).attr('data-id');
              var lesdata = new FormData($('form[data-id^="'+id+'"]').get(0));
              lesdata.append('id', id);
              var that = this;
              alert(document.getElementsByName("mark")[0].value);
              $.ajax({
               url: '/checkedhomework?'+id,
               type: 'POST',
               data: lesdata,
               success: function (json) {
                l.ladda('stop');
                $(that).html("Сохранено");
                $(that).parent().parent().removeClass("notchecked")
                $(that).removeClass("btn-warning");
                $(that).addClass("btn-primary");
              },
              cache: false,
              contentType: false,
              processData: false,
              error: function(response){

                alert(response.responseText);
                toastr.warning('Домашнее задание не загружено<br/>Обратитесь к администратору'); 

              }
            });

            });

 $('.dataTables-example').DataTable({
   "order": [],
   dom: '<"html5buttons"B>lTfgitp',
   buttons: [
   { extend: 'copy'},
   {extend: 'excel', title: 'Домашние задания'},
   {extend: 'pdf', title: 'Домашние задания'}

   ],
   "autoWidth": false


 });
</script>
