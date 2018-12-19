var ldButton = function (post_type, button_id, btn_type, update_field_id, post_id, user_id, url) 
{
    this.post_type = post_type;
    this.button_type = btn_type;
    this.update_field_id = update_field_id;
    this.post_id = post_id;
    this.user_id = user_id;
    this.button_id = button_id;

    $.ajax({
        type: "POST",
        url: url,
        data: {
            post_type:this.post_type,
            upvote_downvote:this.button_type,
            post_id:this.post_id,
            user_id:this.user_id,
            button_type:this.button_type
        },
        success: function (resultData) {
            // Remove first and last bracket
            var data = resultData.substr(1, resultData.length - 2);
            // Split the array
            data = data.split(",");
			var field_id = update_field_id.split("#");
			
			var dump = document.getElementById(field_id[1]).textContent;
			dump = Number(dump);
			
			var updated_field = dump;
			console.log(data);
			if(data[2] == '"upvote"')
			{
				if(data[1] == "false")
				{
					updated_field = dump + 1;
				}
				else if(data[1] == "true")
				{
					
				}
				else
				{
					console.log("Uh Oh data[1] returned something other than true or false");
				}
			}
			else if(data[2] == '"downvote"')
			{	
				if(data[1] == "false")
				{
					updated_field = dump - 1;
				}
			}
			else
			{
				updated_field = updated_field;	
			}
            // Update the data on the website
            $(update_field_id).text(updated_field);
        },
	});
};