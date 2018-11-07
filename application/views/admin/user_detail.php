<?php $this->load->view('admin/header'); ?>
    <!--右侧布局-->
<div style="margin:0px; background-color: white; margin:0 10px;">
    <table class="layui-table">
        <tbody>
        <tr>
            <th width="20%" >用户昵称</th>
            <td  width="30%">
                <input name="" class="layui-input" type="text" value="<?php echo $value['nickname']?>"  />

            </td>


            <th rowspan="2" width="20%">用户头像</th>
            <td rowspan="2" width="30%" >
                <span><img id=avtor  class='img-thumbnail' src=<?php echo $value['headimgurl']?>></span>

            </td>
        </tr>


        <tr>

            <th>用户openid</th>
            <td >
                <input  type="text" class="layui-input" value="<?php echo $value['openid']?>" id="staffcode" />

            </td>

        </tr>

        <tr>
            <th >性别 </th>
            <td  >
                <input name="value[fax]" class="layui-input" type="text" value="<?=config_item('sex')[$value['sex']]?>">
            </td>

            <th  >语言</th>
            <td  >

                <input  type="text" class="layui-input" value="<?php echo $value['language']?>" id="username" />
            </td>

        </tr>
        <tr>
            <th >省份 </th>
            <td  >
                <input name="value[fax]" class="layui-input" type="text" value="<?=$value['province']?>">
            </td>

            <th  >城市</th>
            <td  >

                <input  type="text" class="layui-input" value="<?php echo $value['city']?>" id="username" />
            </td>

        </tr>
        <tr>
            <th >关注时间 </th>
            <td  >
                <input name="value[fax]" class="layui-input" type="text" value="<?=$value['subscribe_time']?>">
            </td>
            <th></th>
            <td></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center">

                <button type="button" class="layui-btn" onclick="parent.layer.close(parent.layer.getFrameIndex(window.name));" data-dismiss="modal"><i class="fa fa-times"></i> 关闭</button>

            </td>
        </tr>
        </tbody>
    </table>

</div>
<?php $this->load->view('admin/footer'); ?>