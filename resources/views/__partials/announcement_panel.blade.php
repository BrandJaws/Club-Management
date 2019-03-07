<div id="vue-announcements-container" class="portlet light bordered" style="height: 434px;">
    <div class="portlet-title tabbable-line">
        <div class="caption">
            <i class="icon-globe font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Communication</span>
        </div>
    </div>
    <div class="portlet-body">
        <form class="social-media-form">
            <div class="form-group">
                <textarea class="form-control media-textbox" name="social-media-text"
                          placeholder="Type Your Message Here" v-model="msgBody"></textarea>
                <p><br></p>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"> </span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="hidden"><input type="file" name="..."> </span>
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md-checkbox-inline row">
                <div class="md-checkbox has-error facebookChk col-md-3">
                    <input type="checkbox" class="md-check" id="checkbox2_3">
                    <label for="checkbox2_3"> <span></span> <span class="check"></span> <span class="box"></span>
                        Facebook </label>
                </div>
                <div class="md-checkbox has-error twitterChk col-md-3">
                    <input type="checkbox" class="md-check" id="checkbox2_4">
                    <label for="checkbox2_4"> <span class="inc"></span> <span class="check"></span> <span
                                class="box"></span> Twitter</label>
                </div>
                <div class="md-checkbox has-error instagramChk col-md-3">
                    <input type="checkbox" class="md-check" id="checkbox2_5">
                    <label for="checkbox2_5"> <span></span> <span class="check"></span> <span class="box"></span>
                        Instagram</label>
                </div>
                <div class="col-md-3 text-right form-group" style="padding-left: 0px; margin-top: -5px;">
                    <button class="btn btn-circle red btn-outline" style="padding: 5px 30px; margin-right: -8px;" type="submit" @click.prevent="submitAnnouncement">Submit</button>
                </div>
            </div>
            {{--<div class="form-group">--}}
                {{--<button class="btn btn-circle red btn-outline" type="submit" @click.prevent="submitAnnouncement">Submit</button>--}}
            {{--</div>--}}
        </form>
    </div>
</div>
