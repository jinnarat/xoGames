<style>
  a{
    margin: 10px;
    color: #337ab7;
  }

  th{
    text-align: center;
  }

  a:active {
    color: #6A5ACD;
    text-decoration: underline !important;
  } 
</style>

    <div class = "row">
      <div class = "container">
        <h1 class="text-center" style="margin: 30px 0;"><span class="glyphicon glyphicon-stats"></span> ประวัติการเล่น</a></h1>
        <div class = "col-md-12">
          <table class="table table-striped table-bordered nowrap" style="width:100%">
            <tr>
              <th>No.</th>
              <th>Player 1 Name</th>
              <th>Player 2 Name</th>
              <th>Winner</th>
            </tr>


          <?php 
            if($results){
             foreach ($results as $key => $result){
            ?> 
              <tr>
                <td class="text-center"><?php echo $result->id ?></td>
                <td><?php echo $result->player1name ?></td>
                <td><?php echo $result->player2name ?></td>
                <td><?php echo $result->winner ?></td>
              </tr> 
            <?php }
              }else{ ?>
              <tr>
                <td class="text-center" colspan="4">ไม่พบข้อมูล</td>
              </tr> 
            <?php }
             ?>
          </table>

          <div class="right">
              <p><?php echo $links; ?></p>
          </div>
    </div>
