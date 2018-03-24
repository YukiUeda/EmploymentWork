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
        console.log(data);
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
                    "data":data["data"],
                    "backgroundColor":[
                      "rgb(255, 00, 00)",
                      "rgb(00, 00, 255)",
                      "rgb(255, 255, 00)",
                      "rgb(00, 80, 00)",
                      "rgb(160, 82, 45)",
                      "rgb(255, 99, 132)",
                      "rgb(255, 165, 0)",
                      "rgb(169, 169, 169)",
                      "rgb(153, 50, 204)",
                      "rgb(100, 149, 237)",
                      "rgb(127, 255, 132)",
                      "rgb(00, 00, 00)",
                    ]
                }]
            },
            options: {
                title: {
                    display: true,
                    fontSize:24,
                    text:data["name"]+'の科目の使用状況',
                }
            }
        });
      })
      .fail(function(data) {
        $('.result').html(data);
      });
    });
  });
