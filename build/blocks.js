(()=>{"use strict";var e={n:t=>{var o=t&&t.__esModule?()=>t.default:()=>t;return e.d(o,{a:o}),o},d:(t,o)=>{for(var n in o)e.o(o,n)&&!e.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:o[n]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.wp.element,o=window.wp.components,n=window.wp.data,r=window.wp.url,s=window.wp.apiFetch;var i=e.n(s);const a=window.wp.editPost,l=()=>{const[e,s]=(0,t.useState)(!1),[l,c]=(0,t.useState)(!1),[d,p]=(0,t.useState)(""),[m,u]=(0,t.useState)([]),[g,w]=(0,t.useState)([]),[E,b]=(0,t.useState)(!1),[_,v]=(0,t.useState)(""),[P,S]=(0,t.useState)("");let y=(0,n.useSelect)("core/editor").getBlocks().filter((e=>"core/paragraph"===e.name||"core/heading"===e.name)),h="";y.map((e=>{h+=e.attributes.content}));const f=e=>{u([]),S(""),p(""),w([]);const t={content:h};"get-excerpts"===e&&v("Most Relevant Excerpts"),"get-titles"===e&&v("Most Relevant Headings"),s(!0),b(!0),((e,t)=>i()({path:(0,r.addQueryArgs)(`/mopen_ai/v1/${e}`,t)}))(e,t).then((t=>{let o=JSON.parse(t);o.error&&o.error.message?S(o.error.message):"get-titles"===e?u(o):w(o),b(!1)})).catch((e=>{p(e.message),s(!1),b(!1),c(!0)}))};return(0,t.createElement)(t.Fragment,null,(0,t.createElement)(a.PluginSidebarMoreMenuItem,{target:"mopenai-settings-sidebar"},"Open AI"),(0,t.createElement)(a.PluginSidebar,{name:"mopenai-settings-sidebar",title:"Open Ai",icon:"admin-settings"},(0,t.createElement)("div",{class:"mopen-ai__body"},(0,t.createElement)("div",{class:"mopen-ai__buton-group"},(0,t.createElement)(o.Button,{isSecondary:!0,onClick:()=>f("get-titles")},"Create titles"),(0,t.createElement)(o.Button,{isPrimary:!0,onClick:()=>f("get-excerpts")},"Create excerpt"))),l&&(0,t.createElement)(o.Notice,{status:"error",isDismissible:!0,onRemove:()=>c(!1)},(0,t.createElement)("p",null,d)),e&&(0,t.createElement)(o.Modal,{title:_,onRequestClose:()=>{u([]),w([]),S(""),c(""),s(!1)}},(0,t.createElement)("div",{class:"components-modal__body"},E&&(0,t.createElement)("div",{class:"components-modal__loader"},(0,t.createElement)(o.Spinner,null)),P&&(0,t.createElement)("div",{class:"components-modal__item"},P),m&&m.map(((e,o)=>(0,t.createElement)("div",{class:"components-modal__item",onClick:()=>(e=>{if(e){const t=(0,n.select)("core/editor").getCurrentPostId();(0,n.dispatch)("core/editor").editPost({title:e,id:t});const o=(0,n.select)("core/editor").getBlocks().find((e=>"core/post-title"===e.name));o?((0,n.dispatch)("core/block-editor").updateBlockAttributes(o.clientId,{title:e}),(0,n.dispatch)("core/editor").editPost({title:e}),console.log("Title updated:",e)):console.log("No title block found.")}else console.log("Title is empty or null.");s(!1)})(e)},`${o+1}) ${e}`))),g&&g.map(((e,o)=>(0,t.createElement)("div",{class:"components-modal__item",onClick:()=>(e=>{if(e){const t=(0,n.select)("core/editor").getCurrentPostId();(0,n.dispatch)("core/editor").editPost({excerpt:e,id:t})}s(!1)})(e)},`${o+1}) ${e}`)))))))},c=()=>{const{registerPlugin:e}=wp.plugins,{getEditedPostAttribute:o}=(0,n.select)("core/editor");return(0,t.useEffect)((()=>{"post"===o("type")&&e("mopen-plugin-sidebar",{render:l})}),[o("type")]),null};wp.domReady((()=>{wp.plugins.registerPlugin("mopen-plugin",{render:c})}))})();