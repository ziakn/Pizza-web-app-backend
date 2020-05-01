<template>
    <v-row justify="center">
        <v-col cols="12">
            <v-btn large dark color="blue-grey" @click="$refs.inputUpload.click()">
                    Add<v-icon right >add_a_photo</v-icon>
                  </v-btn>
                  <input
                    v-show="false"
                    ref="inputUpload"
                    accept="image/*"
                    type="file"
                    multiple
                    @change="profileChange"
                  />

        </v-col>
        <v-col cols="12">
            <v-row v-if="formValue.image.length">
                    <v-col
                    v-for="(image , index) in formValue.image"
                    :key="index"
                    class="d-flex child-flex"
                    cols="2"
                    >
                        <v-card flat >
                            <v-img
                            :src="image.src"
                            aspect-ratio="1"
                            class="grey lighten-2"
                            >
                            <v-btn color="error" @click="removeFromValueImage(index)">x</v-btn>
                            <template v-slot:placeholder>
                                <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                                >
                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                </v-row>
                            </template>
                            </v-img>
                            
                        </v-card>
                    </v-col>
                </v-row>
                    <v-row v-if="images.length!=0">
                        <v-col
                        v-for="(image , index) in images"
                        :key="index"
                        class="d-flex child-flex"
                        cols="2"
                        >
                            <v-card flat >
                                <v-img
                                :src="image"
                                aspect-ratio="1"
                                class="grey lighten-2"
                                >
                                <v-btn color="error" @click="removeImage(index)">x</v-btn>
                                <template v-slot:placeholder>
                                    <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                    >
                                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-row>
                                </template>
                                </v-img>
                                
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-row v-else>
                        <v-col
                         v-for="n in 6"
                         :key="n"
                        class="d-flex child-flex"
                        cols="2"
                        >
                            <v-card flat >
                                <v-img
                                :src="`https://picsum.photos/10/6?image=${n * 5 + 10}`"
                                aspect-ratio="1"
                                class="grey lighten-2"
                                >
                                <template v-slot:placeholder>
                                    <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                    >
                                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-row>
                                </template>
                                </v-img>
                                
                            </v-card>
                        </v-col>
                    </v-row>
        </v-col>
  </v-row>
</template>

<script>
export default {
    data: () =>({

        files:[],
        totalFiles:[],
        images:[],
        pastedImage:'',
        blobFile:'',
    }),
    props:
    {
        formValue:Object,

    },
    methods:
    {
        _getURLObj(){
            return window.URL || window.webkitURL;
        },
        
        removeFromValueImage(i)
        {
            this.formValue.image.splice(i,1)
        },
        removeImage(i)
        {
            this.images.splice(i,1)
            this.totalFiles.splice(i,1)
        },
        profileChange(e)
        {
            console.log(e);
            console.log(event);
            this.files=event.target.files;

        }

    },
    watch:
    {
        files()
        {
            console.log(this.files)
            var files = this.files;
            for (var i = 0; i < files.length; i++) {
                if (files[i].type.indexOf('image') !== -1) {
                // We need to represent the image as a file
                var blob = files[i];
                var URLObj = this._getURLObj();
                this.pastedImage = URLObj.createObjectURL(blob);
                
                this.images.push(URLObj.createObjectURL(blob))
                this.totalFiles.push(files[i])
                this.blobFile=blob;
                console.log(this.pastedImage)
                // // The URL can then be used as the source of an image
                // this._pasteImageSource(source);

                // // Prevent the image (or URL) from being pasted into the contenteditable element
                // e.preventDefault();
                }
            }
            this.$emit('files',this.totalFiles);
        },
    }

}
</script>

<style>

</style>