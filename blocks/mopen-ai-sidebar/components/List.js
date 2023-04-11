const List = (props) => {
    const { posts, excerpts, dispatchTitle, dispatchExcerpts } = props;

    return (
        <>
            { posts && (
                posts.map((item, i) => {
                    return (
                        <div class='components__item' onClick={() => dispatchTitle(item) }>{`${i+1}) ${item}`}</div>
                )})
            )}
            { excerpts && (
                excerpts.map((item, i) => {
                    return (
                        <div class='components__item' onClick={() => dispatchExcerpts(item) }>{`${i+1}) ${item}`}</div>
                )})
            )}
        </>
    )

}
export default List