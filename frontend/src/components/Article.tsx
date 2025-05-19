import { useEffect, useRef, useState } from 'react'
import { useNavigate, useParams, useSearchParams } from 'react-router-dom'
import axios, { HttpStatusCode, isAxiosError } from 'axios'
import type { FocusEvent, FC, JSX, KeyboardEvent, KeyboardEventHandler, RefObject } from 'react'
import type { AxiosError, AxiosResponse } from 'axios'
import Layout from './layout/Layout'
import CustomButton from './shared/CustomButton'
import DelayedLink from './shared/DelayedLink'
import { LinkType, Mode } from '../types/general.types'
import { consoleError, fadeOutAndNavigate, getAuthHeader, getUserId, localDateStr, replaceNewlinesWithBr, selectElementText, setElementText } from '../utils/functions'
import { NAVIGATE_DELAY } from '../utils/constants'
import { defaultArticle, defaultContentText, defaultTitleText } from '../utils/defaults'
import type { IGlobal, Mode as TMode, TArticle } from '../types/general.types'

const Article: FC<IGlobal> = ({ loading, setLoading, theme, setTheme, flashMessage, setFlashMessage, wrapperRef }): JSX.Element => {
  const params = useParams<{ id: string }>()
  const [searchParams, _setSearchParams] = useSearchParams()
  const navigate = useNavigate()
  const [article, setArticle] = useState<TArticle>(defaultArticle)
  const [articleMode, setArticleMode] = useState<TMode>(Mode.Edit)
  const divTitleRef = useRef<HTMLDivElement>(null)
  const divContentRef = useRef<HTMLDivElement>(null)

  // This useEffect fires on every re-render
  useEffect(() => {
    // console.log('useEffect without dep')
    // TODO: Should setPlaceholderTexts be here or in useEffect with empty dep array (componentDidMount/Once per mount)?
    articleMode === Mode.New && setPlaceholderTexts()
    // console.log("searchParams.has('edit'):", searchParams.has('edit'))
    // console.log('params.id:', params.id)
    setArticleMode(searchParams.has('edit') ? Mode.Edit : params.id ? Mode.Show : Mode.New)
  })

  useEffect(() => {
    if (params.id) {
      if (!Number.isInteger(Number(params.id))) {
        setFlashMessage({
          message: 'Invalid article ID',
          type: 'error',
          visible: true,
        })
      } else {
        !(async (): Promise<void> => {
          setLoading!(true)
          let error
          try {
            const response: AxiosResponse = await axios.get(`/articles/${params.id}`, getAuthHeader())
            if (response.status === HttpStatusCode.Ok && response.data) {
              setArticle(response.data)
            }
          } catch (e) {
            if (isAxiosError(e)) {
              error = e as AxiosError
              consoleError(error)
              switch (error.status) {
                case HttpStatusCode.NotFound:
                  setFlashMessage({
                    message: 'Article not found',
                    type: 'error',
                    visible: true,
                  })
                  break
                default:
                  setFlashMessage({
                    message: 'Something unexpected happened.',
                    type: 'error',
                    visible: true,
                  })
              }
            } else {
              console.error(`Error fetching article:\n${e}`)
              setFlashMessage({
                message: `Error fetching article:<br />${e}`,
                type: 'error',
                visible: true,
              })
            }
          } finally {
            // To mock slow network
            // setTimeout(() => {
            setLoading!(false)
            // }, 5000)
          }
        })()
      }
    }
    // TODO: searchParams.get or searchParams.has or something else?
  }, [params.id, searchParams.has('edit')])

  const saveArticle = (): void => {
    const articleData: TArticle = {
      title: (divTitleRef.current as HTMLDivElement).innerText,
      content: (divContentRef.current as HTMLDivElement).innerText,
      created: articleMode === Mode.Edit ? null : localDateStr(),
      modified: localDateStr(),
      userId: getUserId()
    }
    // console.log('articleData: ', articleData)

    articleMode === Mode.Edit ? updateArticle(articleData) : storeArticle(articleData)
  }

  // Update existing Article (PATCH). Partial<Article> because of the PATCH partial update.
  const updateArticle = async (artcl: Partial<TArticle>): Promise<void> => {
    let error
    try {
      const response: AxiosResponse = await axios.patch(`/articles/${params.id}`, artcl, getAuthHeader())
      if (response.status === HttpStatusCode.Ok && response.data) {
        setArticle(response.data)
      }
    } catch (e) {
      if (isAxiosError(e)) {
        error = e as AxiosError
        consoleError(error)
        setFlashMessage({
          message: 'An error occured when updating article',
          type: 'error',
          visible: true,
        })
      } else {
        error = e
        console.error("Error updating article:\n", error)
        setFlashMessage({
          message: `Error updating article:<br />${error}`,
          type: 'error',
          visible: true,
        })
      }
    }
    if (!error) {
      setFlashMessage({
        message: 'Article updated successfully',
        type: 'success',
        visible: true,
      })
      // Initiate fade-out effect on wrapper div
      fadeOutAndNavigate(wrapperRef as RefObject<HTMLDivElement>, '/profile', navigate, NAVIGATE_DELAY, flashMessage, setFlashMessage)
    }
  }

  // Store new Article (POST)
  const storeArticle = async (artcl: TArticle): Promise<void> => {
    let error, newArticleId: number
    try {
      // console.log('params.id:', params.id)
      const response: AxiosResponse = await axios.post('/articles', artcl, getAuthHeader())
      // console.log('response.data:', response.data)
      if (response.status === HttpStatusCode.Created && response.data) {
        setArticle(response.data)
        newArticleId = response.data.id
      }
    } catch (e) {
      if (isAxiosError(e)) {
        error = e as AxiosError
        consoleError(error)
        console.error('Error saving article:', error)
        setFlashMessage({
          message: `Error saving article:<br />${error}`,
          type: 'error',
          visible: true,
        })
      } else {
        error = e
        console.error("Error saving article:\n", error)
        setFlashMessage({
          message: `Error saving article:<br />${error}`,
          type: 'error',
          visible: true,
        })
      }
    }
    if (!error) {
      setFlashMessage({
        message: 'Article created successfully',
        type: 'success',
        visible: true,
      })
      setTimeout(() => {
        navigate(`/articles/${newArticleId}`)
      }, NAVIGATE_DELAY)
      // console.log(articleMode)
      // TODO: is this needed?
      // Change mode to Show
      // setArticleMode(Mode.Show)
    }
  }

  const setPlaceholderTexts = (): void => {
    if (divTitleRef.current && divContentRef.current) {
      setElementText(divTitleRef.current, defaultTitleText)
      setElementText(divContentRef.current, defaultContentText)
      selectElementText(divTitleRef.current, defaultTitleText)
    }
  }

  const keyDownOnElement: KeyboardEventHandler = (key: KeyboardEvent<HTMLDivElement>) => {
    if (key.code.toUpperCase() === 'ENTER' || key.code.toUpperCase() === 'NUMPADENTER') {
      key.preventDefault()
      saveArticle()
    }
  }

  return (
    <Layout loading={loading} theme={theme} setTheme={setTheme} flashMessage={flashMessage} setFlashMessage={setFlashMessage} wrapperRef={wrapperRef}>
      <h3 className="text-2xl font-bold mb-4">{articleMode === Mode.Edit ? 'Edit ' : articleMode === Mode.New ? 'New ' : ''}Article</h3>
      <div
        ref={divTitleRef}
        className={`${articleMode !== Mode.Show ? 'inset-shadow-[2px_2px_5px_rgba(0,0,0,0.3)] p-2 ' : ''}block text-2xl mb-4`}
        dangerouslySetInnerHTML={{ __html: article.title }}
        contentEditable={articleMode !== Mode.Show ? true : false}
        onFocus={(e: FocusEvent<HTMLDivElement>) => { articleMode === Mode.New ? selectElementText(e.target, defaultTitleText) : undefined }}
        onKeyDown={keyDownOnElement}
      />
      <div
        ref={divContentRef}
        className={`${articleMode !== Mode.Show ? 'inset-shadow-[2px_2px_5px_rgba(0,0,0,0.3)] p-2 ' : ''}min-h-32 block mt-2 mb-4`}
        dangerouslySetInnerHTML={{ __html: replaceNewlinesWithBr(article.content) }}
        contentEditable={articleMode !== Mode.Show ? true : false}
        onFocus={(e: FocusEvent<HTMLDivElement>) => { articleMode === Mode.New ? selectElementText(e.target, defaultContentText) : undefined }}
      />
      <div className="flex justify-between items-center mb-4 text-xs">
        <div>Created: {localDateStr(article.created)}</div>
        <div>Modified: {localDateStr(article.modified)}</div>
      </div>
      {articleMode === Mode.Show ? <>
        <DelayedLink wrapperRef={wrapperRef} linkType={LinkType.Button} to="/articles">&laquo; All Articles</DelayedLink>
        <DelayedLink wrapperRef={wrapperRef} linkType={LinkType.Button} className="ml-4" to="?edit">Edit Article</DelayedLink>
      </> : <>
        <DelayedLink wrapperRef={wrapperRef} linkType={LinkType.Button} to={articleMode === Mode.Edit ? `/articles/${params.id}` : '/articles'}>&laquo; Cancel</DelayedLink>
        <CustomButton className="ml-4" type="button" onClick={saveArticle} size="large">{articleMode === Mode.Edit ? 'Update' : 'Save'}</CustomButton>
        </>}
    </Layout>
  )
}

export default Article
