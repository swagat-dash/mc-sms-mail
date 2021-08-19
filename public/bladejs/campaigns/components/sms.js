$(document).ready(function(){

                    "use strict"

                    var campaign_list_url = $('#campaign_list_url').val();
                    var campaign_id = $('#campaign_id').val();

                $('#check_all').on('click', function(e) {
                        if($(this).is(':checked',true))
                        {
                            $(".checking").prop('checked', true);
                        } else {
                            $(".checking").prop('checked',false);
                        }
                        });

                        $('.checking').on('click',function(){
                            if($('.checking:checked').length == $('.checking').length){
                                $('#check_all').prop('checked',true);
                            }else{
                                $('#check_all').prop('checked',false);
                            }
                        });


                        // campaign-email



        $('.campaign-email').on('click', function(e) {


            var idsArr = [];
            var group_ids = [];
            $(".checking:checked").each(function() {
                idsArr.push($(this).attr('data-id'));
            });

            $(".group_id:checked").each(function() {
                group_ids.push($(this).attr('data-group-id'));
            });

            var campaign_email_url = $('#campaign_email_url').val(); //url

            if(idsArr.length <= 0 && group_ids.length <= 0 )
            {
                alert("Please select atleast one record");
            }  else {

                if(confirm("Are you sure?")){

                    var strIds = idsArr.join(",");
                    var strGroupIds = group_ids.join(",");

                    $.ajax({
                        url: campaign_email_url,
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            campaign_id: campaign_id,
                            ids: strIds,
                            groupIds: strGroupIds
                        },
                        success: function (data) {
                            console.table(data);
                            if (data['status']==true) {
                                window.location = campaign_list_url;
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                }
            }
        });

                });
