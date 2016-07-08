\documentclass[landscape]{article}
\usepackage{wallpaper}
\usepackage{niceframe}
\usepackage{xcolor}
\usepackage{ulem}
\usepackage{graphicx}
\usepackage{geometry}
\geometry{tmargin=.4cm,bmargin=.4cm,
lmargin=.4cm,rmargin=.4cm}

\setlength{\columnseprule}{0.4pt}
\columnwidth=0.3\textwidth

%=============================
\usepackage{datatool}
\DTLloaddb{names}{data.csv}
%=============================

\begin{document}



%=============================
\DTLforeach{names}{
\rfirstname=RFirstName, \rmiddlename=RMiddleName, \rlastname=RLastName, \awardtype=AwardType, \date=Date, \signature=Signature, \afirstname=AFirstName, \amiddlename=AMiddleName, \alastname=ALastName, \jobtitle=JobTitle}{
%=============================

\centering
\scalebox{2.95}{\color{green!30!black!60}
\begin{minipage}{.33\textwidth}
\font\border=umrandb
\generalframe
{\border \char113} % up left
{\border \char109} % up
{\border \char112} % up right
{\border \char108} % left 
{\border \char110} % right
{\border \char114} % lower left
{\border \char111} % bottom
{\border \char115} % lower right
{\centering

\begin{minipage}{.9\textwidth}
\centering
\includegraphics[height=1.1cm]{green-arrow-logo.pdf}
\end{minipage}
\vspace{-11mm}

\curlyframe[.9\columnwidth]{

\textcolor{red!10!black!90}
{\small Green Arrow Consulting}\\

\textcolor{green!10!black!90}{
\tiny In honor of outstanding collaboration, work ethic, and productivity we hereby award the}

\smallskip

\textcolor{red!30!black!90}
{\textit{Certificate of}}

\vspace{2mm}

\textcolor{black}{\large \textsc{\awardtype}}

\vspace{4mm}

\tiny
to: \uline{\textcolor{black}
{\rfirstname} { \rmiddlename} { \rlastname}}\\

\vspace{4mm}

{\color{blue!40!black}
\scalebox{0.9}{
\begin{tabular}{ccccc}
\textcolor{green!10!black!90}
{on \textit{\small{\date}}} & &
\includegraphics[height=0.3cm,width=2cm]{\signature}\\


\cline{3-4}

\\
 & & {\afirstname} { \amiddlename} { \alastname} & &  \\
 & & {\jobtitle} & &  \\ 
\end{tabular}
}}}}
\end{minipage}
}

}

\pagebreak
\end{document}