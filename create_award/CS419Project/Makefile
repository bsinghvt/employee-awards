##########################################################################
#
# Makefile pour l'installation unix de fourier avec GNU make
#                     (sans fontes Utopia Expert)
#                                                     B. Gaulle 24/1/2005

# Preciser le texmf ou vous voulez installer l'ensemble 
# (en indiquant le nom de la variable de texmf.cnf concernee):
TARGET-TEXMF-VAR=HOMETEXMF# 
# TARGET-TEXMF-VAR= TEXMFMAIN
# TARGET-TEXMF-VAR= TEXMFLOCAL
# TARGET-TEXMF-VAR=...

# Pour forcer la langue :
#LANG=fr# Les messages seront en francais.
#LANG=en# Messages will be in English.

install-cmd=cp # install, mv, ...
updmap-cmd=updmap #

# fin de la partie de configuration ######################################

CMDT=kpsewhich
ISIT=$(shell type ${CMD} && echo YES || echo)
ifneq ($(ISIT),YES)
  CMD=${CMDT}
  CMDT=updmap
  ISIT=$(shell type ${CMDT} && echo YES || echo)
    ifneq ($(ISIT),YES)
    CMD=${CMDT}
    CMDT=tex
    ISIT=$(shell type ${CMDT} && echo YES || echo)
      ifneq ($(ISIT),YES)
      CMD=${CMDT}
      endif
    endif
endif
ifeq ($(ISIT${CMD}),YES)
TGM=${TARGET-TEXMF-VAR}
TARGETTEXMF=$(shell kpsewhich --expand-var '$$${TGM}')
UPDMAP-CFG-FILE=$(shell ${updmap-cmd} --nomkmap 2>&1 | \
                       grep "using config file" | \
                       sed -e 's/using config file //')
Updmap-CFG-DIR=$(shell dirname ${UPDMAP-CFG-FILE})
PFB-UTOPIA-LOADED=$(shell kpsewhich putr8a.pfb)
DNF=/dev/null
ISITmkdirhier=$(shell $(SHELL) -ec "\
                      mkdirhier tst 2>${DNF} && echo YES || echo ")
ISITwget=$(shell $(SHELL) -ec "\
                      type wget 2>${DNF} && echo YES || echo ")
ifeq (${ISITmkdirhier},YES)
mkdir=mkdirhier
else
mkdir=mkdir
endif
Exists=$(shell ${SHELL} -ec \
			"test -d '${TARGETTEXMF}' >${DNF} && echo YES || echo ")
WriteAble=$(shell ${SHELL} -ec \
			"test -w '${TARGETTEXMF}' >${DNF} && echo YES || echo ")
ifeq ("$(LANG)","$(EMPTY)")
else
	LANGMSG=$(shell ${SHELL} -ec "echo '$(LANG)' | sed -e 's!_.*!!'")
endif

ifeq ($(LANGMSG),)
	LANGMSG=en
endif
ifneq ($(LANGMSG),en)
   ifneq ($(LANGMSG),fr)
	  LANGMSG=en
   endif
endif
PWD=$(shell $(SHELL) -ec "pwd")# This is where we are.
UI=${PWD}/uninstall.sh# Shell de desinstallation
endif

ifeq ($(LANGMSG),fr)
M0="ERREUR : ${CMD} n'a pas ete trouve ! Arret de l'installation."
M1="Vous souhaitez installer le materiel des fontes fourier."
M2="L'emplacement TEXMF choisi peut etre indique au lancement"
M3="du Makefile, actuellement \"make TGM=${TGM}\""
M4="(vous avez le choix entre HOMETEXMF, TEXMFLOCAL et TEXMFMAIN)."
M5="D'ou une installation ici dans ${TARGETTEXMF}." 
M6="MAIS je n'ai pas le droit d'y ecrire ! ERREUR fatale." 
M7="Changer soit de TEXMF soit de nom d'utilisateur."
M8="MAIS cette hierarchie TEXMF n'existe pas"
M9=
M10="Vous avez aussi le choix du niveau d'installation :"
M11="\"make TGM=${TGM} \
			install-min\" copiera les fichiers distribues ;"
M12="\"make TGM=${TGM} \
			install-all\" utilisera ensuite updmap ;"
M13="\"make TGM=${TGM} \
			i-install\" telechargera en plus utopia depuis CTAN."
M14="NB : je ne peux pas telecharger les fontes utopia pour vous."
M15="A vous de decider ce que je dois faire."
M16=
M17=
M18=
M19=
M20="Fin de l'installation complete de FOURIER-GUT."
M21=
M22=
M23=
M24=
M25="Fin de la copie des fichiers dans l'arborescence TEXMF."
M26="Reste a mettre a jour les fichiers de configuration."
M27="Reste aussi a installer les fontes utopia."
M28="Reste a installer les fontes utopia."
M29=
M30="Fin de la mise a jour des fichiers de configuration."
M31=
M32=
M33=
M34=
M35="ATTENTION :"
M36="l'installation ne sera complete qu'apres installation"
M37="des fontes utopia (disponibles sur CTAN dans fonts) : "
M38="putr8a.pfb, putri8a.pfb, putb8a.pfb et putbi8a.pfb."
M39="Faire en ligne \"make  TGM=${TGM} utopia\""
M40="Fin provisioire de l'installation."
M41=
M42=
M43=
M44=
M45="Fin de la mise a jour des fichiers de configuration."
M46=
M47=
M48=
M49=
M50="Desinstallation complete de FOURIER-GUT"	
else
# Decommenter le if et mettre ici les messages en anglais.
M0="ERROR: ${CMD} not found! Installation stopped."
M1="You want to install the fourier fonts"
M2="The location of the choosen TEXMF tree may be specified at the launch"
M3="of the MakeFile, now \"make TGM=${TGM}\""
M4="(you can choose  HOMETEXMF, TEXMFLOCAL or TEXMFMAIN)."
M5="So I will install in ${TARGETTEXMF}." 
M6="BUT I am not allowed to write! Fatal ERROR." 
M7="Change the  TEXMF or the user name."
M8="BUT this TEXMF tree does not exist"
M9=
M10="You can also choose the installation level:"
M11="\"make TGM=${TGM} \
			install-min\" will copy the distributed files;"
M12="\"make TGM=${TGM} \
			install-all\" will launch updmap at the end of installation;"
M13="\"make TGM=${TGM} \
			i-install\" will download Utopia from ctan too."
M14="NB: I can't download Utopia for you."
M15="You have to decide what I must do."
M16=
M17=
M18=
M19=
M20="Installation complete."
M21=
M22=
M23=
M24=
M25="Files have been copied in the TEXMF tree."
M26="Configuation files have to be updated."
M27="And Utopia fonts have to be installed."
M28="Utopia fonts have to be installed."
M29=
M30="Configuration files have been updated."
M31=
M32=
M33=
M34=
M35="BEWARE:"
M36="The installation will be complete only when Utopia fonts"
M37="will be installed (avaible on CTAN in the fonts directory) : "
M38="putr8a.pfb, putri8a.pfb, putb8a.pfb and  putbi8a.pfb."
M39="Do on line \"make  TGM=${TGM} utopia\""
M40="Installation finished but not complete."
M41=
M42=
M43=
M44=
M45="Configuration files have been updated."
M46=
M47=
M48=
M49=
M50="FOURIER-GUT has been uninstalled"	
endif

default:	proposition

install: proposition

proposition:
	@echo "---------------- F O U R I E R - G U T -----------------"
	@echo ""	
	@echo "LANG=${LANGMSG}"	
	@echo ""	
ifneq (${ISIT},YES)
	@echo ${M0} ; echo "" ; exit 999
endif
	@echo ${M1}
	@echo ${M2}
	@echo ${M3}
	@echo ${M4}
	@echo ${M5}
ifneq (${Exists},YES)
	@echo ${M8}
	@echo "" ; exit 2
endif
ifneq (${WriteAble},YES)
	@echo ${M6}
	@echo ${M7}
	@echo "" ; exit 3
endif
	@echo ""
	@echo ${M10}
	@echo ${M11}
	@echo ${M12}
ifneq (${PFB-UTOPIA-LOADED},)
  ifneq (${ISITwget},)
	@echo ${M13}
  else
	@echo  ${M14}
  endif
endif
	@echo ${M15}

i-install: install-all utopia 
	@echo ${M20}
	@echo ""

install-all: install-min updmap	warning	

install-min:		
	@touch ${UI} ; rm ${UI} ; touch ${UI} ; chmod u+x ${UI}
	@echo "# /bin/sh" >> ${UI}
ifneq (${ISITmkdirhier},YES)
	@-${mkdir} ${TARGETTEXMF}/doc 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/doc/latex 2>/dev/null
endif
	@-${mkdir} ${TARGETTEXMF}/doc/latex/fourier 2>/dev/null
	@cd ./doc/latex/fourier/ ;\
	for f in * ;\
	do \
	echo "${install-cmd} $$f ${TARGETTEXMF}/doc/latex/fourier/"  ;\
	echo "rm ${TARGETTEXMF}/doc/latex/fourier/$$f"  >>${UI} ;\
	      ${install-cmd} $$f ${TARGETTEXMF}/doc/latex/fourier/  ;\
	done
	@if test -f ${TARGETTEXMF}/dvips/fourier/fourier.map ; then \
	rm -r ${TARGETTEXMF}/dvips/fourier/ ;\
	fi
ifneq (${ISITmkdirhier},YES)
	@-${mkdir} ${TARGETTEXMF}/fonts 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/map 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/map/dvips 2>/dev/null
endif
	@-${mkdir} ${TARGETTEXMF}/fonts/map/dvips/fourier 2>/dev/null
	@cd ./fonts/map/dvips/fourier/ ;\
	for f in *.map ;\
	do \
	echo "${install-cmd} $$f ${TARGETTEXMF}/fonts/map/dvips/fourier/"  ;\
	echo "rm ${TARGETTEXMF}/fonts/map/dvips/fourier/$$f"  >>${UI} ;\
	      ${install-cmd} $$f ${TARGETTEXMF}/fonts/map/dvips/fourier/  ;\
	done
ifneq (${ISITmkdirhier},YES)
	@-${mkdir} ${TARGETTEXMF}/fonts 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/afm 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/afm/public 2>/dev/null
endif
	@-${mkdir} ${TARGETTEXMF}/fonts/afm/public/fourier 2>/dev/null
	@cd ./fonts/afm/public/fourier/ ;\
	for f in * ;\
	do \
	echo "${install-cmd} $$f ${TARGETTEXMF}/fonts/afm/public/fourier/"  ;\
	echo "rm ${TARGETTEXMF}/fonts/afm/public/fourier/$$f" >>${UI} ;\
	     ${install-cmd} $$f ${TARGETTEXMF}/fonts/afm/public/fourier/  ;\
	done
ifneq (${ISITmkdirhier},YES)
	@-${mkdir} ${TARGETTEXMF}/fonts 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/tfm 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/tfm/public 2>/dev/null
endif
	@-${mkdir} ${TARGETTEXMF}/fonts/tfm/public/fourier 2>/dev/null
	@cd  ./fonts/tfm/public/fourier/ ;\
	for f in * ;\
	do \
	echo "${install-cmd} $$f ${TARGETTEXMF}/fonts/tfm/public/fourier/"  ;\
	echo "rm ${TARGETTEXMF}/fonts/tfm/public/fourier/$$f" >>${UI} ;\
	     ${install-cmd} $$f ${TARGETTEXMF}/fonts/tfm/public/fourier/  ;\
	done
ifneq (${ISITmkdirhier},YES)
	@-${mkdir} ${TARGETTEXMF}/fonts 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/type1 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/type1/public 2>/dev/null
endif
	@-${mkdir} ${TARGETTEXMF}/fonts/type1/public/fourier 2>/dev/null
	@cd ./fonts/type1/public/fourier/ ;\
	for f in * ;\
	do \
	echo "${install-cmd} $$f ${TARGETTEXMF}/fonts/type1/public/fourier/"  ;\
	echo "rm ${TARGETTEXMF}/fonts/type1/public/fourier/$$f" >>${UI} ;\
	     ${install-cmd} $$f ${TARGETTEXMF}/fonts/type1/public/fourier/  ;\
	done
ifneq (${ISITmkdirhier},YES)
	@-${mkdir} ${TARGETTEXMF}/fonts 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/vf 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/fonts/vf/public 2>/dev/null
endif
	@-${mkdir} ${TARGETTEXMF}/fonts/vf/public/fourier 2>/dev/null
	@cd  ./fonts/vf/public/fourier/ ;\
	for f in * ;\
	do \
	echo "${install-cmd} $$f ${TARGETTEXMF}/fonts/vf/public/fourier/"  ;\
	echo "rm ${TARGETTEXMF}/fonts/vf/public/fourier/$$f" >>${UI}  ;\
	     ${install-cmd} $$f ${TARGETTEXMF}/fonts/vf/public/fourier/  ;\
	done
ifneq (${ISITmkdirhier},YES)
	@-${mkdir} ${TARGETTEXMF}/tex 2>/dev/null
	@-${mkdir} ${TARGETTEXMF}/tex/latex 2>/dev/null
endif
	@-${mkdir} ${TARGETTEXMF}/tex/latex/fourier 2>/dev/null
	@cd ./tex/latex/fourier/ ;\
	for f in * ;\
	do \
	echo "${install-cmd} $$f ${TARGETTEXMF}/tex/latex/fourier/"  ;\
	echo "rm ${TARGETTEXMF}/tex/latex/fourier/$$f" >>${UI} ;\
	     ${install-cmd} $$f ${TARGETTEXMF}/tex/latex/fourier/  ;\
	done
	@echo ${M25}
	@echo ${M26}
ifeq (${PFB-UTOPIA-LOADED},)
	@echo ${M27}
endif

updmap:	
	@-${mkdir} ${TARGETTEXMF}/web2c 2>/dev/null
	@if test ! -f ${TARGETTEXMF}/web2c/updmap.cfg ; then \
	cp ${UPDMAP-CFG-FILE} ${TARGETTEXMF}/web2c/ ;\
	fi
	@echo "${updmap-cmd} --cnffile ${TARGETTEXMF}/web2c/updmap.cfg \
		             --nohash \
		             --enable Map fourier.map"
	@${updmap-cmd} --cnffile ${TARGETTEXMF}/web2c/updmap.cfg \
		       --nohash \
		       --enable Map fourier.map
	@texhash ${TARGETTEXMF}
	@echo ${M30}
ifeq (${PFB-UTOPIA-LOADED},)
	@echo ${M28}
endif

warning:	
ifeq (${PFB-UTOPIA-LOADED},)
	@echo ""
	@echo ${M35}
	@echo ${M36}
	@echo ${M37}
	@echo ${M38}
ifneq (${ISITwget},)
	@echo ${M39}
endif
	@echo ${M40}
endif

utopia: ${TARGETTEXMF}/fonts/adobe/utopia/putr8a.pfb \
	${TARGETTEXMF}/fonts/adobe/utopia/putri8a.pfb \
	${TARGETTEXMF}/fonts/adobe/utopia/putb8a.pfb \
	${TARGETTEXMF}/fonts/adobe/utopia/putbi8a.pfb
	@texhash ${TARGETTEXMF}
	@echo "Fontes utopia installees"

${TARGETTEXMF}/fonts/adobe/utopia/putr8a.pfb:
ifneq (${ISITmkdirhier},YES)
	@-${mkdir} ${TARGETTEXMF}/fonts/type1/adobe
endif
	@-${mkdir} ${TARGETTEXMF}/fonts/type1/adobe/utopia
	@cd ${TARGETTEXMF}/fonts/type1/adobe/utopia/ ;\
	wget -nc http://www.ctan.org/tex-archive/fonts/utopia/putr8a.pfb
	@echo "rm ${TARGETTEXMF}/fonts/type1/adobe/utopia/putr8a.pfb" >>${UI}

${TARGETTEXMF}/fonts/adobe/utopia/putri8a.pfb:	
	@cd ${TARGETTEXMF}/fonts/type1/adobe/utopia/ ;\
	wget -nc http://www.ctan.org/tex-archive/fonts/utopia/putri8a.pfb
	@echo "rm ${TARGETTEXMF}/fonts/type1/adobe/utopia/putri8a.pfb" >>${UI}

${TARGETTEXMF}/fonts/adobe/utopia/putb8a.pfb:
	@cd ${TARGETTEXMF}/fonts/type1/adobe/utopia/ ;\
	wget -nc http://www.ctan.org/tex-archive/fonts/utopia/putb8a.pfb
	@echo "rm ${TARGETTEXMF}/fonts/type1/adobe/utopia/putb8a.pfb" >>${UI}

${TARGETTEXMF}/fonts/adobe/utopia/putbi8a.pfb:	
	@cd ${TARGETTEXMF}/fonts/type1/adobe/utopia/ ;\
	wget -nc http://www.ctan.org/tex-archive/fonts/utopia/putbi8a.pfb
	@echo "rm ${TARGETTEXMF}/fonts/type1/adobe/utopia/putbi8a.pfb" >>${UI}

uninstall:
	@echo "Retrait des fichiers installes."
	@if test -f ${TARGETTEXMF}/web2c/updmap.cfg ; then \
	${updmap-cmd} --cnffile ${TARGETTEXMF}/web2c/updmap.cfg \
		      --nohash \
		      --disable fourier.map ;\
	echo ${M45} ;\
	fi
	@-${SHELL} ${UI} ; rm ${UI}
	@texhash ${TARGETTEXMF}
	@echo ${M50}

clean:	
	@-rm ${UI}
#########################################################################

