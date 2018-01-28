$(function() {
  $('.modal').modal();

  var mychart = null;
  $('.modal-trigger').on('click',function() {
    if(mychart != null){
      mychart.destroy();
    }
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/company/product/chart',
        type: 'POST',
        data:{
            'id':$(this).parent().data('product')
        }
      })
      .done(function(data) {
        mychart = new Chart(document.getElementById("chart"),{
            type: 'pie',
            "data":{
                "labels":[
                  '国語',
                  '算数',
                  '英語',
                  '理科',
                  '社会',
                  '音楽',
                  '家庭科',
                  '体育',
                  '図工',
                  '道徳',
                  '生活',
                  '総合',
                ],
                "datasets":[{
                    "label":data["name"]+'の科目の使用状況',
                    "data":data["data"],
                    "backgroundColor":[
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 99, 132)",
                    ]
                }]
            }
        });
      })
      .fail(function(data) {
        $('.result').html(data);
      });
    });
  });
