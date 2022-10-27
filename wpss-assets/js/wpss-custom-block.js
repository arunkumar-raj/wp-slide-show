const {registerBlockType} = wp.blocks; //Blocks API
const {createElement} = wp.element; //React.createElement
const {__} = wp.i18n; //translation functions
registerBlockType( 'wpssslideshow/myslideshow', {
	title: __( 'My Slideshow' ), // Block title.
	icon: 'cover-image',
	category:  __( 'media' ), //category
	attributes: {
	},
	//display the edit interface + preview
	edit(attributes,setAttributes){
		return createElement('div', {}, '[myslideshow]' )
	},
	save(){
		return '{ [myslideshow] }';
	}

});
