<div>目前位置:首頁 > 分類網誌 > <span id="navTag"></span></div>
<div style="display: flex;">
    <fieldset style="width: 20%;">
        <legend>分類項目</legend>
        <!-- data-type 可以重複使用 -->
        <a><p class="tag" data-type="1">健康新知</p></a>
        <a><p class="tag" data-type="2">菸害防治</p></a>
        <a><p class="tag" data-type="3">癌症防治</p></a>
        <a><p class="tag" data-type="4">慢性病防治</p></a>
    </fieldset>
    <fieldset style="width: 70%;">
        <div id="newslist">文章列表</div>
        <div id="news" style="display: none;"></div>
    </fieldset>
</div>
    
<script>
    $(".tag").on('click', function() {
        let navtag = $(this).text()
        $("#navTag").text(navtag)
        let type=$(this).data('type')
        getlist(type)
    })

    function getlist(type){
        $.get("api/getlist.php",{type},(list)=>{
            $("#newslist").html(list)
            $("#newslist").show()
            $("#news").hide()
        })
    }
    function getnews(id){
        $.get("api/getnews.php",{id},(news)=>{
            $("#newslist").html(news)
            $("#newslist").show()
            $("#news").hide()
        })
    }
</script>